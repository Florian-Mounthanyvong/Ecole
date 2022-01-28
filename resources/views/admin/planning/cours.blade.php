
@extends('modele')
@section('title','Menu')
@section('contents')
    @foreach($cour as $cours)
        <p>{{$cours->id}}: {{$cours->intitule}} <a href="{{route('achoixform',['cours_id'=>$cours->id])}}"><strong><button>Ajouter une séance</button></strong></a>
            <br>Formation: {{$cours->formation->intitule}}
        <br> Crée le: {{$cours->created_at}} Modifié le : {{$cours->updated_at}}
        <br>Enseignant assigné: {{$cours->user->nom}} {{$cours->user->prenom}}</p>
        <hr />
    @endforeach


    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
    <p> <a href="/admin"><button> Retour au menu principal</button></a></p>

@endsection
