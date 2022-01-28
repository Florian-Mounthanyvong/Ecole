@extends('modele')
@section('title','Menu')
@section('contents')
    @foreach($formations as $formation)
        <p>{{$formation->id}}: {{$formation->intitule}} <a href="{{route('feditform',['id'=>$formation->id])}}"><strong><button>Modifier</button></strong></a>
            <a href="{{route('fsupprform',['id'=>$formation->id])}}"><strong><button>Supprimer</button></strong></a>
        <br> Crée le: {{$formation->created_at}} Modifié le : {{$formation->updated_at}}
        <hr />
    @endforeach

    <p><a href="/formations/ajout"> <strong><button>Ajouter une formation</button></strong></a></p>
    <p> <a href="/admin"><button> Retour au menu principal</button></a></p>

@endsection
