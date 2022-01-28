@extends('modele')
@section('title','Liste enseignants')
@section('contents')
    @foreach($users as $user)
        {{$user->id}}: Nom: {{$user->nom}}, Prénom: {{$user->prenom}} Login: {{$user->login}} Type d'utilisateur: {{$user->type}}
        <a href="{{route('choix',['id'=>$user->id])}}"><strong><button>Ajouter une séance à l'un de ses cours</button></strong></a>
        <br>
    @endforeach
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
