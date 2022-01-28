@extends('modele')
@section('title','Menu')
@section('contents')
    Affichage par cours:

    @foreach($cours as $cour)
        @foreach($cour->plannings->sortBy('date_debut') as $planning)
            <p><strong>{{$cour->intitule}}</strong>
                <br>Du: {{$planning->date_debut}}
                <br>Au: {{$planning->date_fin}}
            </p>
        @endforeach
        <hr />
    @endforeach

    <a href="/etudiant/planning/search"><button>Rechercher un cours</button></a>
    <hr />
    <p> <a href="/etudiant"><button> Retour au menu principal</button></a></p>

@endsection
