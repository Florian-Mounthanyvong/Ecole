
@extends('modele')
@section('title','Menu')
@section('contents')

    @foreach($plannings as $planning)
        <p><strong>Formation: {{$planning->cour->formation->intitule}}</strong>
            <br>{{$planning->cour->intitule}}
            <a href="{{route('peditform',['id'=>$planning->id])}}"><strong><button>Modifier la séance</button></strong></a>
                <a href="{{route('psupprform',['id'=>$planning->id])}}"><strong><button>Supprimer la séance</button></strong></a>
                <br>
            Du: {{$planning->date_debut}} <br>
            Au: {{$planning->date_fin}}</p>
        <hr />
    @endforeach
    <a href="/enseignant/cours"><strong><button>Choisir un cours pour ajouter une séance</button></strong></a>
    <hr />
    <p><a href="/enseignant/planning"> <strong><button>Tout voir</button></strong></a></p>
    <p><a href="/enseignant/tri"> <strong><button>Voir par cours</button></strong></a></p>
    <hr />
    <p> <a href="/enseignant"><button> Retour au menu principal</button></a></p>

@endsection
