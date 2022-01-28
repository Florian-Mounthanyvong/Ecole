@extends('modele')
@section('title','Ajout')
@section('contents')
    @error('nom')
    <p>Erreur dans le nom : {{$message}}</p>
    @enderror
    @error('prenom')
    <p>Erreur dans le prénom: {{$message}}</p>
    @enderror
    @error('login')
    <p>Erreur dans le login: {{$message}}</p>
    @enderror
    @error('formation')
    <p>Erreur dans la formation: {{$message}}</p>
    @enderror
    @error('mdp')
    <p>Erreur dans le mot de passe: {{$message}}</p>
    @enderror
    @error('type')
    <p>Erreur dans le type d'utilisateur: {{$message}}</p>
    @enderror

    <form action="" method="post">
        Nom: <input type="text" name="nom" value="{{old('nom')}}">
        Prénom: <input type="text" name="prenom" value="{{old('prenom')}}"><br>
        Login: <input type="text" name="login" value="{{old('login')}}">
        Formation:
        <select id="formation_id" name="formation_id">
            @foreach ($formations as $formation)
                <option value="{{ $formation->id }}">{{$formation->intitule}}
            @endforeach
            <option value="{{old('formation_id')}}" selected >Aucune
            </option>
        </select>
        Mot de passe: <input type="password" name="mdp" value="{{old('mdp')}}"><br>
        Type d'utilisateur: <select id="type" name="type">
            <option value="etudiant">Etudiant</option>
            <option value="enseignant">Enseignant</option>
            <option value="admin">Administrateur</option>
            <option value="NULL" selected>Aucun
        </select>
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
