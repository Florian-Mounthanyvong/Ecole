@extends('modele')
@section('title','Ajout')
@section('contents')

    @error('intitule')
    <p>Erreur dans l'intitulé' : {{$message}}</p>
    @enderror

    <form action="{{route('cchoix',['formation_id'=>$formation->id])}}" method="post">
        Intitulé: <input type="text" name="intitule" value="{{old('intitule')}}"> <br>
        <input type="hidden" name="formation_id" value="{{$formation->id}}">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
