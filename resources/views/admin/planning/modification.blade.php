@extends('modele')
@section('title','Ajout')
@section('contents')

    @error('date_debut')
    <p>Erreur dans la date de début : {{$message}}</p>
    @enderror
    @error('date_fin')
    <p>Erreur dans la date de fin : {{$message}}</p>
    @enderror
    Horaire précédente:
    <p>Formation: {{$planning->cour->formation->intitule}}
        <br>{{$planning->id}}: {{$planning->cour->intitule}} par {{$planning->cour->user->nom}} {{$planning->cour->user->prenom}}
        <br>
        {{$planning->date_debut}} <br>
        {{$planning->date_fin}}</p>
    <form action="{{route('aedit',['id'=>$planning->id])}}" method="post">
        Début: <input type="datetime-local" name="date_debut" value="{{$planning->date_debut}}"> <br>
        Fin: <input type="datetime-local" name="date_fin" value="{{$planning->date_fin}}">
        <input type="submit" value="Modifier">
        @csrf
    </form>
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection

