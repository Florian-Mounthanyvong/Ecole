@extends('modele')
@section('title','Modification')
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

    <form action="{{route('uedit',['id'=>$user->id])}}" method="post">
        Nom: <input type="text" name="nom" value="{{$user->nom}}">
        Prénom: <input type="text" name="prenom" value="{{$user->prenom}}"><br>
        Login: <input type="text" name="login" value="{{$user->login}}">
        Formation:
        <select id="formation_id" name="formation_id">
            @foreach ($formations as $formation)
                <option value="{{ $formation->id }}">{{$formation->intitule}}
            @endforeach
                <option value="{{old('formation_id')}}" >Aucune
                <option value="{{$user->formation_id}}" selected>Ne pas changer
                </option>
        </select>
        Mot de passe: <input type="password" name="mdp" value="{{old('mdp')}}"><br>
        Type d'utilisateur: <select id="type" name="type">
            <option value="etudiant">Etudiant</option>
            <option value="enseignant">Enseignant</option>
            <option value="admin">Administrateur</option>
            <option value="NULL">Aucun
            <option value="{{$user->type}}" selected>Ne pas changer
        </select>
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
