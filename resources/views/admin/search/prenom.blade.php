@extends('modele')
@section('contents')
    @error('prenom')
    <p>Erreur dans le prenom: {{$message}}</p>
    @enderror
    <form action="" method="post">
        Prénom: <input type="text" name="prenom" value="{{old('prenom')}}">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
