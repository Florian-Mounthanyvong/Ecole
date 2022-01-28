<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\User;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Fonction pour afficher la liste de tous les utilisateurs
    public function list(){
        $user = User::all();
        return view('admin.user.liste',['users'=>$user]);
    }
    //Fonction pour filtrer que les enseignants
    public function tri_enseignant(){
        $user = User::where('type', '=', 'enseignant')->get();
        $path = 'admin.user.liste';
        return view($path,['users'=>$user]);
    }
    //Fonction pour assigner l'enseignant choisi à un cours
    public function assign(Request $request,$id){
        $cour = Cours::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'max:40',
        ]);
        $cour->user_id = $validated['user_id'];
        $cour->save();
        if($cour->user_id==1){
            return redirect('/users')->with('etat', 'Enseignant désassigné!');
        }
        return redirect('/users')->with('etat', 'Enseignant assigné!');
    }
    //Fonction pour afficher la liste des cours afin d'y assigner l'enseignant choisi
    public function listcours($id){
        $cour= Cours::where('user_id','=','1')->orWhere('user_id','=',$id)->get();
        $user = User::findOrFail($id);
        $path = 'admin.user.cours';
        return view($path,['user'=>$user,'cour'=>$cour]);
    }
    //Fonction pour filtrer que les étudiants
    public function tri_etudiant(){
        $user = User::where('type', '=', 'etudiant')->get();
        $path = 'admin.user.liste';
        return view($path,['users'=>$user]);
    }
    //Fonction pour filtrer que les utilisateurs non-validés
    public function tri_validation(){
        $user = User::where('type', '=', 'NULL')->get();
        $path = 'admin.user.liste';
        return view($path,['users'=>$user]);
    }
    //Fonction pour chercher des utilisateurs en fonction de leur nom
    public function searchNom(Request $request){
        $validated = $request->validate([
            'nom' => 'required|string|max:40',
        ]);
        $nom = $validated['nom'];
        $user = User::where('nom', '=', $nom)->get();
        $path = 'admin.user.liste';
        return view($path,['users'=>$user]);
    }
    //Fonction pour chercher des utilisateurs en fonction de leur prénom
    public function searchPrenom(Request $request){
        $validated = $request->validate([
            'prenom' => 'required|string|max:40',
        ]);
        $prenom = $validated['prenom'];
        $user = User::where('prenom', '=', $prenom)->get();
        $path = 'admin.user.liste';
        return view($path,['users'=>$user]);
    }
    //Fonction pour chercher un utilisateur en fonction de leur login
    public function searchLogin(Request $request){
        $validated = $request->validate([
            'login' => 'required|max:40',
        ]);
        $login = $validated['login'];
        $user = User::where('login', '=', $login)->get();
        $path = 'admin.user.liste';
        return view($path,['users'=>$user]);
    }
    //Formulaire de recherche de nom
    public function searchFormn()
    {
        return view('admin.search.nom');
    }
    //Formulaire de recherche de prénom
    public function searchFormp()
    {
        return view('admin.search.prenom');
    }
    //Formulaire de recherche de login
    public function searchForml()
    {
        return view('admin.search.login');
    }
    //Formulaire d'ajout d'utilisateur
    public function addForm()
    {
        $formations=Formation::all();
        return view('admin.user.ajout',['formations'=>$formations]);
    }
    //Fonction pour ajouter un utilisateur
    public function add(Request $request){

        $validated = $request->validate([
            'nom' => 'required|string|max:40',
            'prenom' => 'required|string|max:40',
            'login' => 'required|max:30|unique:users',
            'mdp' => 'required|max:60',
            'formation_id' => 'max:60',
            'type' => 'required|alpha|max:40|starts_with:admin,enseignant,etudiant,NULL',
        ]);
        $user = new User();
        $user->nom = $validated['nom'];
        $user->prenom = $validated['prenom'];
        $user->login = $validated['login'];
        $user->formation_id = $validated['formation_id'];
        $user->mdp =  Hash::make($request->mdp);
        $user->type= $validated['type'];
        $user->save();
        $request->session()->flash('etat', 'Ajout effectué !');
        return redirect('/users')->with('etat', 'Ajout effectué !');

    }
    //Fonction pour supprimer un utilisateur. Empêche la suppression du compte admin de base
    public function delete(Request $request,$id){
        $user = User::findOrFail($id);
        if($id==1){
            return redirect('/users')->with('etat', 'Ce compte ne peut pas être supprimé !');
        }

            foreach($user->cour as $cour) {
                $cour->user()->dissociate();
                $cour->user_id=1;
                $cour->save();
            }
        $cours=Cours::all();
        foreach($cours as $cour) {
            $user->cours()->detach($cour);
            $user->save();
        }
        $validated = $request->validate([
            'id' => 'bail|required|integer|gte:0|lte:120',

        ]);
        $id = $validated['id'];

        $user->delete();
        $request->session()->flash('etat', 'Suppression effectuée !');
        return redirect('/users')->with('etat', 'Suppression effectuée !');
    }
    //Formulaire de confirmation de suppression d'utilisateur
    public function deleteForm($id){
        $user = User::findOrFail($id);
            return view('admin.user.suppression',['user'=>$user]);
    }
    //Fonction afin de modifier un utilisateur. Empêche la modification du type du compte admin de base
    public function modify(Request $request,$id){

        $user = User::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'string|max:40',
            'prenom' => 'string|max:40',

            'mdp' => 'max:60',
            'formation_id' => 'max:60',
            'type' => 'alpha|max:40|starts_with:admin,enseignant,etudiant,NULL',
        ]);
        $user->nom = $validated['nom'];
        $user->prenom = $validated['prenom'];
        if($user->login!=$request->login)
        {
            $user->login = $request->validate(['login' => 'max:40|unique:users',]);
        }

        $f= Formation::find($user->formation_id);
        $user->formation()->associate($f);
        if($request->mdp!=null)
        {$user->mdp =Hash::make($validated['mdp']);}
        $user->type= $validated['type'];
        if($user->id==1&&$user->type!='admin'){
            $user->type='admin';
            $user->save();
            return redirect('/users')->with('etat', 'Modification effectuée (le type de ce compte ne peut être modifié)');
        }
        if($user->type=='etudiant'&&$user->formation_id!=$request->formation_id){
            $user->formation_id = $validated['formation_id'];
        $cours=Cours::all();
            foreach($cours as $cour) {
                $user->cours()->detach($cour);
                $user->save();
            }
        }
        $user->formation_id = $validated['formation_id'];
        $user->save();

        $request->session()->flash('etat', 'Modification effectuée !');
        return redirect('/users')->with('etat', 'Modification effectuée !');
    }
    //Formulaire de modification de compte
    public function modifyForm($id){
        $user = User::findOrFail($id);
        $formations=Formation::all();
            return view('admin.user.modification',['user'=>$user,'formations'=>$formations]);
    }

    //Formulaire de modification de type
    public function formType($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.type',['user'=>$user]);
    }
    //Fonction pour modifier le type de l'utilisateur choisi
    public function type(Request $request,$id)
    {
        $user = User::findorfail($id);
        if($user->id==1){
            return redirect('/users')->with('etat', 'Le type de ce compte ne peut être modifié');
        }
        $request->validate([
            'type' => 'alpha|max:40|starts_with:admin,enseignant,etudiant,NULL'
        ]);
            foreach($user->cour as $cour) {
                $cour->user()->dissociate();
                $cour->user_id=1;
                $cour->save();
            }
            foreach($user->cours as $cours) {
                $cours->user()->detach($user);
            }
            if($user->type=='enseignant'||$user->type=='admin'){
                $user->formation_id=null;
            }
        $user->type = $request->type;
        $user->save();
        $path = '/users';
        return redirect($path);
    }

}
