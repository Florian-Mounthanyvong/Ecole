<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Pages d'accueil et de connexion/inscription
 */

//Page d'accueil Laravel
Route::get('/', function () {return view('welcome');});
//Page d'accueil pour les admins
Route::get('/admin', function () { return view('admin.home');});
Route::view('/admin','admin.home')->middleware('auth')->middleware('is_admin');
//Page d'accueil pour les enseignants
Route::get('/enseignant', function () {return view('enseignant.home');});
Route::view('/enseignant','enseignant.home')->middleware('auth')->middleware('is_enseignant');
//Page d'accueil pour les étudiants
Route::get('/etudiant', function () {return view('etudiant.home');});
Route::view('/etudiant','etudiant.home')->middleware('auth')->middleware('is_etudiant');
//Page d'accueil pour les utilisateurs non-validés
Route::get('/guest', function () {return view('guest');});
//Page pour se connecter
Route::get('/login', [\App\Http\Controllers\AuthenticatedSessionController::class,'formLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthenticatedSessionController::class,'login']);
//Permet de se déconnecter
Route::get('/logout', [\App\Http\Controllers\AuthenticatedSessionController::class,'logout'])->name('logout');
//Permet d'entrer ses informations (après avoir choisi sa formation) afin de créer un compte
Route::post('/register/{id}',[\App\Http\Controllers\RegisterUserController::class,'register'])->name('fchoix');
Route::get('/register/{id}',[\App\Http\Controllers\RegisterUserController::class,'formRegister'])->name('fchoixform');
//Permet de changer le mot de passe du compte administrateur si le seul compte admin est celui de base et on ne connait pas son mot de passe
Route::get('/bloque', [\App\Http\Controllers\RegisterUserController::class,'formMdp']);
Route::post('/bloque', [\App\Http\Controllers\RegisterUserController::class,'mdp']);
/* Gérer son compte */

//Menu pour choisir si on veut modifier son mot de passe ou son nom/prénom
Route::get('/compte', function () {
    return view('auth.compte');
});
//Modifier son mot de passe
Route::get('/compte/mdp', [\App\Http\Controllers\AuthenticatedSessionController::class,'formMdp'])->name('mdp');
Route::post('/compte/mdp', [\App\Http\Controllers\AuthenticatedSessionController::class,'mdp']);
//Modifier son nom ou/et son prénom
Route::get('/compte/nom', [\App\Http\Controllers\AuthenticatedSessionController::class,'formNom'])->name('nom');
Route::post('/compte/nom', [\App\Http\Controllers\AuthenticatedSessionController::class,'nom']);

/*
 * Partie enseignant
 */

/* Cours */

//Liste des cours auxquels l'enseignant est assigné. Permet d'ajouter des séances à un cours
Route::get('/enseignant/cours',[\App\Http\Controllers\CoursController::class,'list'])->middleware('auth')->middleware('is_enseignant');

/* Planning */

//Planning de l'enseignant avec les séances triées en fonction de leurs horaires
Route::get('/enseignant/planning',[\App\Http\Controllers\PlanningController::class,'list'])->middleware('auth')->middleware('is_enseignant');
Route::get('/enseignant/tri',[\App\Http\Controllers\PlanningController::class,'tri_cours'])->middleware('auth')->middleware('is_enseignant');
//Ajout d'une séance à un cours
Route::get('/enseignant/planning/{cours_id}/ajout',[\App\Http\Controllers\PlanningController::class,'addForm'])->name('pchoixform')->middleware('auth')->middleware('is_enseignant');
Route::post('/enseignant/planning/{cours_id}/ajout',[\App\Http\Controllers\PlanningController::class,'add'])->name('pchoix')->middleware('auth')->middleware('is_enseignant');
//Suppression d'une séance
Route::get('/enseignant/planning/{id}/suppression',[\App\Http\Controllers\PlanningController::class,'deleteForm'])->name('psupprform')->middleware('auth')->middleware('is_enseignant');
Route::post('/enseignant/planning/{id}/suppression',[\App\Http\Controllers\PlanningController::class,'delete'])->name('psuppr')->middleware('auth')->middleware('is_enseignant');
//Modification d'une séance
Route::get('/enseignant/planning/{id}/modification',[\App\Http\Controllers\PlanningController::class,'modifyForm'])->name('peditform')->middleware('auth')->middleware('is_enseignant');
Route::post('/enseignant/planning/{id}/modification',[\App\Http\Controllers\PlanningController::class,'modify'])->name('pedit')->middleware('auth')->middleware('is_enseignant');

/*
 * Partie étudiant
 */

/* Cours */

//Liste des cours de la formation dans laquelle l’étudiant est inscrit. Permet de s'inscrire/désinscrire des cours
Route::post('/etudiant/cours',[\App\Http\Controllers\CoursController::class,'inscription'])->name('eassign')->middleware('auth')->middleware('is_etudiant');
Route::get('/etudiant/cours',[\App\Http\Controllers\CoursController::class,'list'])->name('eassignform')->middleware('auth')->middleware('is_etudiant');
//Recherche par intitulé d'un cours de la formation de l'étudiant
Route::get('/etudiant/cours/search',[\App\Http\Controllers\CoursController::class,'searchForm'])->middleware('auth')->middleware('is_etudiant');
Route::post('/etudiant/cours/search',[\App\Http\Controllers\CoursController::class,'search'])->middleware('auth')->middleware('is_etudiant');
//Liste des cours dans lesquels l'étudiant est inscrit
Route::get('/etudiant/inscrit',[\App\Http\Controllers\CoursController::class,'tri_inscrit'])->middleware('auth')->middleware('is_etudiant');

/* Planning */

//Affichage du planning de l'étudiant avec les séances regroupées par matières et triées en fonction des horaires
Route::get('/etudiant/planning',[\App\Http\Controllers\PlanningController::class,'list'])->middleware('auth')->middleware('is_etudiant');
//Recherche des séances d'un cours spécifique
Route::get('/etudiant/planning/search',[\App\Http\Controllers\PlanningController::class,'searchForm'])->middleware('auth')->middleware('is_etudiant');
Route::post('/etudiant/planning/search',[\App\Http\Controllers\PlanningController::class,'search'])->middleware('auth')->middleware('is_etudiant');
Route::get('/etudiant/planning/tri',[\App\Http\Controllers\PlanningController::class,'tri_cours'])->middleware('auth')->middleware('is_etudiant');
/*
 * Partie admin
 */

/* Gérer les plannings */

//Planning de l'enseignant avec les séances triées en fonction de leurs horaires
Route::get('/planning',[\App\Http\Controllers\PlanningController::class,'list'])->middleware('auth')->middleware('is_admin');
Route::get('/planning/tri',[\App\Http\Controllers\PlanningController::class,'tri_cours'])->middleware('auth')->middleware('is_admin');
//Ajout d'une séance à un cours
Route::get('/planning/{cours_id}/ajout',[\App\Http\Controllers\PlanningController::class,'addForm'])->name('achoixform')->middleware('auth')->middleware('is_admin');
Route::post('/planning/{cours_id}/ajout',[\App\Http\Controllers\PlanningController::class,'add'])->name('achoix')->middleware('auth')->middleware('is_admin');
//Suppression d'une séance
Route::get('/planning/{id}/suppression',[\App\Http\Controllers\PlanningController::class,'deleteForm'])->name('asupprform')->middleware('auth')->middleware('is_admin');
Route::post('/planning/{id}/suppression',[\App\Http\Controllers\PlanningController::class,'delete'])->name('asuppr')->middleware('auth')->middleware('is_admin');
//Modification d'une séance
Route::get('/planning/{id}/modification',[\App\Http\Controllers\PlanningController::class,'modifyForm'])->name('aeditform')->middleware('auth')->middleware('is_admin');
Route::post('/planning/{id}/modification',[\App\Http\Controllers\PlanningController::class,'modify'])->name('aedit')->middleware('auth')->middleware('is_admin');
//Choix d'un enseignant pour ensuite lui ajouter une séance de cours parmi les matières qu'il gère
Route::get('/planning/enseignant',[\App\Http\Controllers\PlanningController::class,'tri_enseignant'])->middleware('auth')->middleware('is_admin');
//Liste des cours auxquels l'enseignant choisi est assigné
Route::get('/planning/{id}/cours',[\App\Http\Controllers\PlanningController::class,'liste_cours'])->name('choix')->middleware('auth')->middleware('is_admin');


/* Gérer les formations */

//Liste des formations avec accès à la modification/suppression/ajout pour les admins et accès à l'inscription pour les utilisateurs non-connectés
Route::get('/formations',[\App\Http\Controllers\FormationController::class,'list']);
//Ajout d'une formation
Route::post('/formations/ajout',[\App\Http\Controllers\FormationController::class,'add'])->middleware('auth')->middleware('is_admin');
Route::get('/formations/ajout',[\App\Http\Controllers\FormationController::class,'addForm'])->middleware('auth')->middleware('is_admin');
//Suppression d'une formation
Route::post('/formations/{id}/suppression',[\App\Http\Controllers\FormationController::class,'delete'])->name('fsuppr')->middleware('auth')->middleware('is_admin');
Route::get('/formations/{id}/suppression',[\App\Http\Controllers\FormationController::class,'deleteForm'])->name('fsupprform')->middleware('auth')->middleware('is_admin');
//Modification d'une formation
Route::post('/formations/{id}/modification',[\App\Http\Controllers\FormationController::class,'modify'])->name('fedit')->middleware('auth')->middleware('is_admin');
Route::get('/formations/{id}/modification',[\App\Http\Controllers\FormationController::class,'modifyForm'])->name('feditform')->middleware('auth')->middleware('is_admin');

/* Gérer les cours */

//Liste des cours existants
Route::get('/cours',[\App\Http\Controllers\CoursController::class,'list'])->middleware('auth')->middleware('is_admin');
//Liste des formations existantes afin d'y ajouter des cours
Route::get('/cours/choix',[\App\Http\Controllers\CoursController::class,'listFormation'])->middleware('auth')->middleware('is_admin');
//Ajout d'un cours à une formation
Route::post('/cours/{formation_id}/ajout',[\App\Http\Controllers\CoursController::class,'add'])->name('cchoix')->middleware('auth')->middleware('is_admin');
Route::get('/cours/{formation_id}/ajout',[\App\Http\Controllers\CoursController::class,'addForm'])->name('cchoixform')->middleware('auth')->middleware('is_admin');
//Suppression d'un cours
Route::post('/cours/{id}/suppression',[\App\Http\Controllers\CoursController::class,'delete'])->name('csuppr')->middleware('auth')->middleware('is_admin');
Route::get('/cours/{id}/suppression',[\App\Http\Controllers\CoursController::class,'deleteForm'])->name('csupprform')->middleware('auth')->middleware('is_admin');
//Modification d'un cours
Route::post('/cours/{id}/modification',[\App\Http\Controllers\CoursController::class,'modify'])->name('cedit')->middleware('auth')->middleware('is_admin');
Route::get('/cours/{id}/modification',[\App\Http\Controllers\CoursController::class,'modifyForm'])->name('ceditform')->middleware('auth')->middleware('is_admin');
//Recherche d'un cours par intitulé
Route::post('/cours/search',[\App\Http\Controllers\CoursController::class,'search'])->middleware('auth')->middleware('is_admin');
Route::get('/cours/search',[\App\Http\Controllers\CoursController::class,'searchForm'])->middleware('auth')->middleware('is_admin');
//Tri des cours par enseignants
Route::get('/cours/tri',[\App\Http\Controllers\CoursController::class,'sortedlist'])->middleware('auth')->middleware('is_admin');
//Assignation d'un enseignant à un cours
Route::post('/cours/{id}/assign',[\App\Http\Controllers\CoursController::class,'assign'])->name('cassign')->middleware('auth')->middleware('is_admin');
Route::get('/cours/{id}/assign',[\App\Http\Controllers\CoursController::class,'tri_enseignant'])->name('cassignform')->middleware('auth')->middleware('is_admin');

/* Gérer les utilisateurs */

//Liste dee TOUS les utilisateurs
Route::get('/users',[\App\Http\Controllers\UserController::class,'list'])->middleware('auth')->middleware('is_admin');
//Recherche par nom
Route::post('/users/searchn',[\App\Http\Controllers\UserController::class,'searchNom'])->middleware('auth')->middleware('is_admin');
Route::get('/users/searchn',[\App\Http\Controllers\UserController::class,'searchFormn'])->middleware('auth')->middleware('is_admin');
//Recherche par prénom
Route::post('/users/searchp',[\App\Http\Controllers\UserController::class,'searchPrenom'])->middleware('auth')->middleware('is_admin');
Route::get('/users/searchp',[\App\Http\Controllers\UserController::class,'searchFormp'])->middleware('auth')->middleware('is_admin');
//Recherche par login
Route::post('/users/searchl',[\App\Http\Controllers\UserController::class,'searchLogin'])->middleware('auth')->middleware('is_admin');
Route::get('/users/searchl',[\App\Http\Controllers\UserController::class,'searchForml'])->middleware('auth')->middleware('is_admin');
//Tri par enseignant
Route::get('/users/enseignants',[\App\Http\Controllers\UserController::class,'tri_enseignant'])->middleware('auth')->middleware('is_admin');
//Tri par étudiant
Route::get('/users/etudiants',[\App\Http\Controllers\UserController::class,'tri_etudiant'])->middleware('auth')->middleware('is_admin');
//Tri par utilisateur non-validé
Route::get('/users/validation',[\App\Http\Controllers\UserController::class,'tri_validation'])->middleware('auth')->middleware('is_admin');
//Ajout d'un utilisateur
Route::post('/users/ajout',[\App\Http\Controllers\UserController::class,'add'])->middleware('auth')->middleware('is_admin');
Route::get('/users/ajout',[\App\Http\Controllers\UserController::class,'addForm'])->middleware('auth')->middleware('is_admin');
//Suppression d'un utilisateur
Route::post('/users/{id}/suppression',[\App\Http\Controllers\UserController::class,'delete'])->name('usuppr')->middleware('auth')->middleware('is_admin');
Route::get('/users/{id}/suppression',[\App\Http\Controllers\UserController::class,'deleteForm'])->name('usupprf')->middleware('auth')->middleware('is_admin');
//Modification d'un utilisateur
Route::post('/users/{id}/modification',[\App\Http\Controllers\UserController::class,'modify'])->name('uedit')->middleware('auth')->middleware('is_admin');
Route::get('/users/{id}/modification',[\App\Http\Controllers\UserController::class,'modifyForm'])->name('ueditf')->middleware('auth')->middleware('is_admin');
//Assignation d'un enseignant à un cours
Route::post('/users/{id}/assign',[\App\Http\Controllers\UserController::class,'assign'])->name('uassign')->middleware('auth')->middleware('is_admin');
Route::get('/users/{id}/assign',[\App\Http\Controllers\UserController::class,'listcours'])->name('uassignform')->middleware('auth')->middleware('is_admin');
//Changer le type d'un utilisateur choisi
Route::get('/users/{id}/type', [\App\Http\Controllers\UserController::class,'formType'])->name('utypef')->middleware('auth')->middleware('is_admin');
Route::post('/users/{id}/type', [\App\Http\Controllers\UserController::class,'type'])->name('utype')->middleware('auth')->middleware('is_admin');

