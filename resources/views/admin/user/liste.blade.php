@extends('modele')
@section('title','Liste utilisateurs')
@section('contents')
    @foreach($users as $user)
        <p>{{$user->id}}: Nom: {{$user->nom}}, Prénom: {{$user->prenom}} <br> Login: {{$user->login}} <br>
            Formation:@if($user->formation==null)Aucune
            @else{{$user->formation->intitule}}@endif <br>
            Type d'utilisateur: {{$user->type}}
            <a href="{{route('ueditf',['id'=>$user->id])}}"><strong><button>Modifier</button></strong></a>
            <a href="{{route('usupprf',['id'=>$user->id])}}"><strong><button>Supprimer</button></strong></a>
            <a href="{{route('utypef',['id'=>$user->id])}}"><strong><button>Changer le type</button></strong></a>
            @if($user->type=='enseignant')
                <a href="{{route('uassignform',['id'=>$user->id])}}"><strong><button>Assigner à un cours</button></strong></a>
            @endif</p>
        <hr />
    @endforeach
    <p><a href="/users/ajout"><button>Ajouter</button></a></p>
    <p><a href="/users"><button>Tout voir</button></a></p>
    <hr />
    Filtrer par:
    <a href="/users/etudiants"><button>Etudiant</button></a>
    <a href="/users/enseignants"><button>Enseignant</button></a>
    <a href="/users/validation"><button>En attente de validation </button></a><br>
    <hr />
    Rechercher par:
    <a href="/users/searchn"><button>Nom</button></a>
    <a href="/users/searchp"><button>Prénom</button></a>
    <a href="/users/searchl"><button>Login</button></a></p>
    <hr />
    <p> <a href="/admin"><button>Retour au menu principal</button></a><br>

@endsection
