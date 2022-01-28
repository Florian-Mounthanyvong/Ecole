<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Planning;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class PlanningController extends Controller
{

    //Fonction pour afficher tous les plannings accessibles en fonction du type de l'utilisateur
    public function list(){
        $user = Auth::user();
        switch ($user->type) {
            case 'admin':
                $plannings= Planning::orderBy('date_debut')->get();
                $path = 'admin.planning.liste';
                break;
            case 'enseignant':

                $plannings= $user->plannings->sortBy('date_debut');
                $path = 'enseignant.planning.liste';
                break;
            case 'etudiant':
                $cours=$user->cours()->get();//Liste des cours auxquels l'étudiant est inscrit
                $path='etudiant.planning';
                $plannings=array();
                foreach($cours as $cour)
            {
                foreach($cour->plannings as $planning)
                {
                    array_push($plannings,$planning);
                }
            }
                //Tri array en fonction de la date_debut
                $plannings = Arr::sort($plannings, function($planning){return $planning->date_debut;} );

                break;
            default:
                $path = '/guest';
                break;
        }

        return view($path,['plannings'=>$plannings]);
    }

    //Liste des enseignants
    public function tri_enseignant(){
        $user = User::where('type', '=', 'enseignant')->get();
        $path = 'admin.planning.enseignant';
        return view($path,['users'=>$user]);
    }
    //Liste des cours assignés au professeur choisi
    public function liste_cours($id){
            $user=User::findorFail($id);
        $cour= Cours::where('user_id', '=', $user->id)->get();
                $path = 'admin.planning.cours';
        return view($path,['cour'=>$cour]);
    }
    //Fonction d'affichage des séances de cours triées par matières
    public function tri_cours(){
        $user = Auth::user();
        switch ($user->type) {
            case 'admin':
                $plannings= Planning::orderBy('cours_id')->orderBy('date_debut')->get();
                $path = 'admin.planning.liste';
                break;
            case 'enseignant':

                $plannings= $user->plannings->sortBy('date_debut')->sortBy('cours_id');
                $path = 'enseignant.planning.liste';
                break;
            case 'etudiant':
                $cours=$user->cours()->get();//Liste des cours auxquels l'étudiant est inscrit
                $path='etudiant.tri';
                return view($path,['cours'=>$cours]);
                break;
            default:
                $path = '/guest';
                break;
        }

        return view($path,['plannings'=>$plannings]);
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
                $plannings= Planning::all();
                $path = 'admin.planning.liste';
                break;
            case 'enseignant':
                $plannings= $user->plannings->sortBy('date_debut');
                $path = 'enseignant.planning.liste';
                break;
            case 'etudiant':
                $cours=$user->cours()->where('intitule', '=', $intitule)->get();
                $path='etudiant.planning';
                return view($path,['cours'=>$cours]);
                break;
            default:
                $path = '/guest';
                break;
        }
        return view($path,['plannings'=>$plannings]);
    }
    //Formulaire de recherche d'un cours spécifique
    public function searchForm()
    {
        return view('admin.cours.search');
    }
    //Formulaire d'ajout de séance de cours
    public function addForm($cours_id)
    {
        $cours= Cours::findOrFail($cours_id);
        $user = Auth::user();
        switch ($user->type) {
            case 'admin':
                $path = 'admin.planning.ajout';
                break;
            case 'enseignant':
                $path = 'enseignant.planning.ajout';
                break;
            case 'etudiant':
                $path='/etudiant/planning';
                break;
            default:
                $path = '/guest';
                break;
        }
        return view($path,['cours'=>$cours]);
    }
    //Fonction pour ajouter une séance à un cours
    public function add(Request $request,$cours_id){
        $validated = $request->validate([
            'date_debut' => 'required|date|after:now',
            'date_fin' => 'required|date|after:date_debut',

        ]);
        $format = "d/m/y \à H:i ";
        $planning = new Planning();
        $planning->date_debut = date($format, strtotime($validated['date_debut']));
        $planning->date_fin = date($format, strtotime($validated['date_fin']));
        $planning->cours_id=$cours_id;
        $planning->save();
        $request->session()->flash('etat', 'Ajout effectué !');
        $user = Auth::user();
        switch ($user->type) {
            case 'admin':
                $path = '/planning';
                break;
            case 'enseignant':
                $path = '/enseignant/planning';
                break;
            case 'etudiant':
                $path='/etudiant/planning';
                break;
            default:
                $path = '/guest';
                break;
        }
        return redirect($path)->with('etat', 'Ajout effectué');

    }
    //Fonction pour supprimer une séance de cours
    public function delete(Request $request,$id){
        $planning = Planning::findOrFail($id);
        $validated = $request->validate([
            'id' => 'bail|required|integer|gte:0|lte:120',

        ]);
        $id = $validated['id'];
        $planning->cour()->dissociate();
        $planning->delete();
        $request->session()->flash('etat', 'Suppression effectuée !');
        $user = Auth::user();
        switch ($user->type) {
            case 'admin':
                $path = '/planning';
                break;
            case 'enseignant':
                $path = '/enseignant/planning';
                break;
            case 'etudiant':
                $path='/etudiant/planning';
                break;
            default:
                $path = '/guest';
                break;
        }
        return redirect($path)->with('etat', 'Suppression effectuée !');
    }
    //Formulaire pour confirmer la suppression de la séance de cours choisie
    public function deleteForm($id){
        $planning= Planning::findOrFail($id);
        $user = Auth::user();
        switch ($user->type) {
            case 'admin':
                $path = 'admin.planning.suppression';
                break;
            case 'enseignant':
                $path = 'enseignant.planning.suppression';
                break;
            case 'etudiant':
                $path='/etudiant/planning';
                break;
            default:
                $path = '/guest';
                break;
        }
        return view($path,['planning'=>$planning]);
    }
    //Fonction pour modifier la séance de cours choisi
    public function modify(Request $request,$id){
        $planning= Planning::findOrFail($id);
        $validated = $request->validate([
            'date_debut' => 'required|date|after:now',
            'date_fin' => 'required|date|after:date_debut',

        ]);
        $format = "d/m/y \à H:i ";
        $planning->date_debut = date($format, strtotime($validated['date_debut']));
        $planning->date_fin = date($format, strtotime($validated['date_fin']));
        $planning->save();
        $request->session()->flash('etat', 'Modification effectuée !');
        $user = Auth::user();
        switch ($user->type) {
            case 'admin':
                $path = '/planning';
                break;
            case 'enseignant':
                $path = '/enseignant/planning';
                break;
            case 'etudiant':
                $path='/etudiant/planning';
                break;
            default:
                $path = '/guest';
                break;
        }
        return redirect($path)->with('etat', 'Modification effectuée !');
    }
    //Formulaire pour modifier les horaires d'une séance
    public function modifyForm($id){
        $planning = Planning::findOrFail($id);
        $user = Auth::user();
        switch ($user->type) {
            case 'admin':
                $path = 'admin.planning.modification';
                break;
            case 'enseignant':
                $path = 'enseignant.planning.modification';
                break;
            case 'etudiant':
                $path='/etudiant/planning';
                break;
            default:
                $path = '/guest';
                break;
        }
        return view($path,['planning'=>$planning]);
    }



    public function commandujour()
    {
        $commandes = Commande::where('created_at', '>=', Carbon::today())->get();
        return view('admin.commandujour',['commandes'=>$commandes]);
    }

}
