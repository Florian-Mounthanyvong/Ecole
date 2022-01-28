<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoursController extends Controller
{
    //Fonction pour afficher tous les cours accessibles en fonction du type de l'utilisateur
    public function list(){
        $user = Auth::user();

        switch ($user->type) {
            case 'admin':
                $cour= Cours::all();
                $path = 'admin.cours.liste';
                break;
            case 'enseignant':
                $cour= Cours::where('user_id', '=', $user->id)->get();
                $path = 'enseignant.liste';
                break;
            case 'etudiant':
                $cour= Cours::where('formation_id', '=', $user->formation_id)->get();
                $path='etudiant.liste';
                break;
            default:
                $path = '/guest';
                break;
        }

        return view($path,['cour'=>$cour]);
    }
    //Fonction pour qu'un étudiant s'inscrive à un cours
    public function inscription(Request $request){
        $cour = Cours::findOrFail($request->id);
        $user= Auth::user();
        $t=$user->cours()->find($request->id);

        if(!$t){
            $user->cours()->attach($cour);
            return redirect('/etudiant/cours')->with('etat', 'Inscription effectuée!');
        }
        else{
           $user->cours()->detach($cour);
           return redirect('/etudiant/cours')->with('etat', 'Désinscription effectuée!');
        }
    }
    //Fonction pour afficher la liste des cours auxquels l'étudiant est inscrit
    public function tri_inscrit(){
        $cour= Auth::user()->cours()->get();
        $path = 'etudiant.liste';
        return view($path,['cour'=>$cour]);
    }
    //Fonction pour afficher tous les cours triés en fonction de leur enseignant
    public function sortedlist(){

        $cour= Cours::orderBy('user_id')->get();
        $path = 'admin.cours.liste';
        return view($path,['cour'=>$cour]);
    }
    //Fonction pour afficher toutes les formations afin d'y ajouter des cours
    public function listFormation(){
            $f = Formation::all();
            $path = 'admin.cours.formation';
        return view($path,['formations'=>$f]);
    }
    //Fonction pour rechercher un cours spécifique
    public function search(Request $request){
        $validated = $request->validate([
            'intitule' => 'required|max:40',
        ]);
        $intitule = $validated['intitule'];
        $user = Auth::user();
        switch ($user->type) {
            case 'admin':
                $cour = Cours::where('intitule', '=', $intitule)->get();
                $path = 'admin.cours.liste';
                break;
            case 'enseignant':
                $cour = Cours::where('intitule', '=', $intitule)->get();
                $path = '/enseignant';
                break;
            case 'etudiant':
                $cour= Cours::where('formation_id', '=', $user->formation_id)->where('intitule', '=', $intitule)->get();
                $path='etudiant.liste';
                break;
            default:
                $path = '/guest';
                break;
        }
        return view($path,['cour'=>$cour]);
    }
    //Formulaire de recherche d'un cours spécifique
    public function searchForm()
    {
        return view('admin.cours.search');
    }
    //Formulaire d'ajout de cours
    public function addForm($formation_id)
    {
        $formation= Formation::findOrFail($formation_id);
        return view('admin.cours.ajout',['formation'=>$formation]);
    }
    //Fonction pour ajouter un cours à une formation
    public function add(Request $request,$formation_id){

        $validated = $request->validate([
            'intitule' => 'required|alpha_dash|max:40',

        ]);
        $cour = new Cours();
        $cour->intitule = $validated['intitule'];
        $cour->formation_id=$formation_id;
        $cour->user_id=1;
        $cour->save();
        $request->session()->flash('etat', 'Ajout effectué !');
        return redirect('/cours')->with('etat', 'Ajout effectué !');

    }
    //Fonction pour supprimer un cours
    public function delete(Request $request,$id){
        $cour = Cours::findOrFail($id);
        $validated = $request->validate([
            'id' => 'bail|required|integer|gte:0|lte:120',

        ]);
        $id = $validated['id'];
        $cour->user()->dissociate();
        foreach($cour->users as $users) {
            $users->cours()->detach($cour);
        }
        foreach($cour->plannings as $planning) {
            $planning->cour()->dissociate();
            $planning->delete();
        }
        $cour->delete();
        $request->session()->flash('etat', 'Suppression effectuée !');
        return redirect('/cours')->with('etat', 'Suppression effectuée !');
    }
    //Formulaire pour confirmer le cours qu'on veut supprimer
    public function deleteForm($id){
        $cour= Cours::findOrFail($id);
        return view('admin.cours.suppression',['cour'=>$cour]);
    }
    //Fonction pour assigner un professeur au cours choisi
    public function assign(Request $request,$id){
        $cour = Cours::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'max:40',
        ]);

        $cour->user_id = $validated['user_id'];
        $cour->save();

        if($cour->user_id==1){
            return redirect('/cours')->with('etat', 'Enseignant désassigné!');
        }

        return redirect('/cours')->with('etat', 'Enseignant assigné!');
    }
    //Fonction pour afficher la liste des enseignants afin de choisir qui assigner au cours choisi
    public function tri_enseignant($id){
        $cour = Cours::findOrFail($id);
        $user = User::where('type', '=', 'enseignant')->get();
        $path = 'admin.cours.enseignant';
        return view($path,['users'=>$user,'cours'=>$cour]);
    }
    //Fonction pour modifier l'intitulé du cours choisi
    public function modify(Request $request,$id){
        $cour = Cours::findOrFail($id);
        $validated = $request->validate([
            'intitule' => 'alpha_dash|max:40',
            'formation_id' => 'max:60',
        ]);

        $cour->intitule = $validated['intitule'];
        $cour->formation_id = $validated['formation_id'];
        $cour->save();

        $request->session()->flash('etat', 'Modification effectuée !');
        return redirect('/cours')->with('etat', 'Modification effectuée !');
    }
    //Formulaire pour modifier le nom du cours
    public function modifyForm($id){
        $cour = Cours::findOrFail($id);
        $formations=Formation::all();
        return view('admin.cours.modification',['cour'=>$cour,'formations'=>$formations]);
    }
}
