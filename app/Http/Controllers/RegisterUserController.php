<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    //Formulaire d'inscription
    public function formRegister($id)
    {
        if($id==0)
        {
            return view('auth.register',['formation'=>null]);
        }
        $formation=Formation::findOrFail($id);
        return view('auth.register',['formation'=>$formation]);
    }
    //Fonction pour s'inscrire
    public function register(Request $request,$id)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'login' => 'required|string|max:30|unique:users',
            'formation_id' => 'max:50',
            'mdp' => 'required|string|confirmed',
        ]);
        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->login = $request->login;
        $user->formation_id = $request->formation_id;
        $user->mdp =  Hash::make($request->mdp);
        $user->save();
        return redirect('/formations')->with('etat', 'Votre inscription a bien été enregistrée !');
    }
    //Formulaire de modification de mot de passe
    public function formMdp()
    {
        return view('auth.bloque');
    }
    //Fonction pour modifier son mot de passe
    public function mdp(Request $request)
    {
        $request->validate([
            'mdp' => 'required|string',
            'mdp_confirmation'=>'required|same:mdp',
        ]);
        $user = User::findorfail(1);
        $user->mdp = Hash::make($request->mdp);
        $user->save();
        switch ($user->type) {
            case 'admin':
                $path = '/admin';
                break;
            case 'enseignant':
                $path = '/enseignant';
                break;
            case 'etudiant':
                $path='/etudiant';
                break;
            default:
                $path = '/guest';
                break;
        }
        return redirect($path);
    }
}
