<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    //Formulaire de connexion
    public function formLogin()
    {
        return view('auth.login');
    }
    //Fonction pour permettre la connexion, redirige vers la page appropriée en fonction du type de l'utilisateur qui se connecte
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'mdp' => 'required|string'
        ]);
        $credentials = ['login' => $request->input('login'),
            'password' => $request->input('mdp')];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

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
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);

    }
    //Formulaire de modification de mot de passe
    public function formMdp()
    {
        return view('auth.mdp');
    }
    //Fonction pour modifier son mot de passe
    public function mdp(Request $request)
    {
        $request->validate([
            'old_mdp'=>'required|password',
            'mdp' => 'required|string',
            'mdp_confirmation'=>'required|same:mdp',
        ]);
        $user = Auth::user();
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
    //Formulaire de modification de nom/prénom
    public function formNom()
    {
        return view('auth.nom');
    }
    //Fonction pour modifier son nom/prénom
    public function nom(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom'=> 'required|string',
        ]);
        $user = Auth::user();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
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

    //Fonction pour se déconnecter
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
