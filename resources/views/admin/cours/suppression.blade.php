@extends('modele')
@section('title','Suppression')
@section('contents')
    @error('id')
    <p>Erreur dans l'id': {{$message}}</p>
    @enderror

    <form method="post" action="{{route('csuppr',['id'=>$cour->id])}}">
        Id: <input type="text" name="id" value="{{$cour->id}}">
        <input type="submit" value="Confirmer la suppression">
        @csrf
    </form>
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
