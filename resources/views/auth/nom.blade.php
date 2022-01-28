@extends('modele')
@section('title','Modification')
@section('contents')
    @error('nom')
    <p>Erreur dans le nom : {{$message}}</p>
    @enderror
    @error('prenom')
    <p>Erreur dans le prénom : {{$message}}</p>
    @enderror

    <form method="post">
        Nom: <input type="text" name="nom" value="{{Auth::user()->nom}}">
        Prénom: <input type="text" name="prenom" value="{{Auth::user()->prenom}}">
        <input type="submit" value="Valider">
        @csrf
    </form>
    <hr />
    <p> <a href="javascript:history.back()"> <button>Retour</button></a></p>
@endsection
