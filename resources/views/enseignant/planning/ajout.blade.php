@extends('modele')
@section('title','Ajout')
@section('contents')

    @error('date_debut')
    <p>Erreur dans la date de début : {{$message}}</p>
    @enderror
     @error('date_fin')
    <p>Erreur dans la date de fin : {{$message}}</p>
     @enderror
    @error('today')
    <p>Erreur dans la date du jour : {{$message}}</p>
    @enderror

    <form action="{{route('pchoix',['cours_id'=>$cours->id])}}" method="post">

        Début: <input type="datetime-local" name="date_debut" value="{{old('date_debut')}}"> <br>
        Fin: <input type="datetime-local" name="date_fin" value="{{old('date_fin')}}">
        <input type="submit" value="Ajouter">
        @csrf
    </form>
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection

