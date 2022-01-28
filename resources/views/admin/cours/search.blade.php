@extends('modele')
@section('contents')
    @error('intitule')
    <p>Erreur dans l'intitulé: {{$message}}</p>
    @enderror
    <form action="" method="post">
        Intitulé: <input type="text" name="intitule" value="{{old('intitule')}}">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
