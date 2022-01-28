
@extends('modele')
@section('title','Menu')
@section('contents')
    @foreach($plannings as $planning)
        <p><strong>Formation: {{$planning->cour->formation->intitule}}</strong>
            <br>{{$planning->cour->intitule}}
            @if($planning->cour->user->id==1)
                <br>Pas d'enseignant pour l'instant
                @else par {{$planning->cour->user->nom}} {{$planning->cour->user->prenom}}
            @endif
            <a href="{{route('aeditform',['id'=>$planning->id])}}"><strong><button>Modifier la séance</button></strong></a>
            <a href="{{route('asupprform',['id'=>$planning->id])}}"><strong><button>Supprimer la séance</button></strong></a>
            <br>
            Du: {{$planning->date_debut}} <br>
            Au: {{$planning->date_fin}}</p>
        <hr />
    @endforeach
    <a href="/planning/enseignant"><strong><button>Ajouter une séance</button></strong></a>


<p>
    <p><a href="/planning"> <strong><button>Tout voir</button></strong></a></p>
    <p><a href="/planning/tri"> <strong><button>Voir par cours</button></strong></a></p>
    <p><a href="/planning/"> <strong><button>Voir par semaine</button></strong></a></p>
    <p> <a href="/admin"><button> Retour au menu principal</button></a></p>

@endsection
