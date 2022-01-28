@extends('modele')
@section('title','Ajout')
@section('contents')

    @error('intitule')
    <p>Erreur dans l'intitulé' : {{$message}}</p>
    @enderror

    <form method="post" action="{{route('fedit',['id'=>$formation->id])}}">
        Intitulé: <input type="text" name="intitule" value="{{$formation->intitule}}"> <br>
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
