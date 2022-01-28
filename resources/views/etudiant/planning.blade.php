@extends('modele')
@section('title','Menu')
@section('contents')

    @foreach($plannings as $planning)
        <p>
            <strong>{{$planning->cour->intitule}}</strong>
            <br>
            Du: {{$planning->date_debut}} <br>
            Au: {{$planning->date_fin}}</p>
        <hr />
    @endforeach

    <a href="/etudiant/planning/search"><button>Rechercher un cours</button></a>
    <a href="/etudiant/planning/tri"><button>Tri par cours</button></a>
    <hr />
    <p> <a href="/etudiant"><button> Retour au menu principal</button></a></p>

@endsection
