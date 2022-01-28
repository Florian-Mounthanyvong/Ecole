@extends('modele')
@section('contents')
    @error('nom')
    <p>Erreur dans le nom: {{$message}}</p>
    @enderror
    <form action="" method="post">
        Nom:<input type="text" name="nom" value="{{old('nom')}}">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
