<?php

namespace App\Http\Controllers;


use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    //Cas Admin: Fonction pour afficher la liste des formations ainsi que toutes les options de modifications.
    //Cas Non-connecté: Fonction pour proposer les formations auxquelles l'utilisateur peut s'inscrire
    public function list(){

        $user = Auth::user();

        if($user!=null && $user->type=='admin')
        {
            $f = Formation::all();
            $path = 'admin.formation.liste';
        }
        else{
            $f = Formation::all();
            $path = 'auth.formation';
        }

        return view($path,['formations'=>$f]);
    }
    //Formulaire d'ajout de formation
    public function addForm()
    {
        return view('admin.formation.ajout');
    }
    //Fonction pour ajouter des formations
    public function add(Request $request){

        $validated = $request->validate([
            'intitule' => 'required|alpha_dash|max:40',

        ]);
        $formation = new Formation();
        $formation->intitule = $validated['intitule'];
        $formation->save();
        $request->session()->flash('etat', 'Ajout effectué !');
        return redirect('/formations')->with('etat', 'Ajout effectué !');

    }
    //Fonction pour supprimer une formation choisie
    public function delete(Request $request,$id){
        $formation = Formation::findOrFail($id);
        $validated = $request->validate([
            'id' => 'bail|required|integer|gte:0|lte:120',

        ]);
        $id = $validated['id'];
        foreach($formation->users as $users) {
            $users->formation()->dissociate();
            $users->save();
        }
        foreach($formation->cours as $cour ) {
            $cour ->formation()->dissociate();
            $cour->user()->dissociate();
            foreach($cour->users as $users) {
                $users->cours()->detach($cour);
            }
            foreach($cour->plannings as $planning) {
                $planning->cour()->dissociate();
                $planning->delete();
            }
            $cour ->delete();
        }
        $formation->delete();
        $request->session()->flash('etat', 'Suppression effectuée !');
        return redirect('/formations')->with('etat', 'Suppression effectuée !');
    }
    //Formulaire de confirmation de suppression de formation
    public function deleteForm($id){
        $formation = Formation::findOrFail($id);
        return view('admin.formation.suppression',['formation'=>$formation]);
    }
    //Fonction pour modifier une formation choisie
    public function modify(Request $request,$id){
        $formation = Formation::findOrFail($id);
        $validated = $request->validate([
            'intitule' => 'alpha_dash|max:40',
        ]);

        $formation->intitule = $validated['intitule'];
        $formation->save();

        $request->session()->flash('etat', 'Modification effectuée !');
        return redirect('/formations')->with('etat', 'Modification effectuée !');
    }
    //Formulaire de modification de formation
    public function modifyForm($id){
        $formation = Formation::findOrFail($id);
        return view('admin.formation.modification',['formation'=>$formation]);
    }
}
