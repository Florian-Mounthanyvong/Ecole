@extends('modele')
@section('title','Menu')
@section('contents')
    @foreach($cour as $cours)
        <p>{{$cours->id}}: {{$cours->intitule}} <a href="{{route('pchoixform',['cours_id'=>$cours->id])}}"><strong><button>Ajouter une séance</button></strong></a>
            <br>Formation: {{$cours->formation->intitule}}</p>
        <hr />
    @endforeach

    <a href="/enseignant/planning"><strong><button>Voir son planning</button></strong></a>
    <hr />
    <p> <a href="/enseignant"><button> Retour au menu principal</button></a></p>

@endsection
