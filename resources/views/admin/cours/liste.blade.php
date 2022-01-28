@extends('modele')
@section('title','Menu')
@section('contents')
    @foreach($cour as $cours)
        <p>{{$cours->id}}: {{$cours->intitule}} <a href="{{route('ceditform',['id'=>$cours->id])}}"><strong><button>Modifier</button></strong></a>
            <a href="{{route('csupprform',['id'=>$cours->id])}}"><strong><button>Supprimer</button></strong></a>
            <br> Crée le: {{$cours->created_at}} Modifié le : {{$cours->updated_at}}
            <br> Formation: {{$cours->formation->intitule}}
            <br>Enseignant assigné:
            @if($cours->user_id==1)Personne <a href="{{route('cassignform',['id'=>$cours->id])}}"><strong><button>Assigner un enseignant</button></strong></a>
            @else{{$cours->user->nom}} {{$cours->user->prenom}}
        <form method="post" action="{{route('cassign',['id'=>$cours->id])}}">
            <input type="hidden" name="intitule" value="{{$cours->intitule}}">
            <input type="hidden" name="user_id" value="1">
            <input type="submit" value="Désassigner">
            @csrf
        </form>@endif
        <hr />
    @endforeach

    <p><a href="/cours/choix"> <strong><button>Ajouter un cours</button></strong></a></p>
    <p><a href="/cours"><button>Tout voir</button></a></p>
    Rechercher par:
    <a href="/cours/search"><button>Intitulé</button></a> <br>
    <a href="/cours/tri"><button>Trier par enseignant</button></a>
    <p> <a href="/admin"><button> Retour au menu principal</button></a></p>

@endsection
