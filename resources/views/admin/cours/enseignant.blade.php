@extends('modele')
@section('title','Liste utilisateurs')
@section('contents')
    @foreach($users as $user)
        {{$user->id}}: Nom: {{$user->nom}}, Prénom: {{$user->prenom}} Login: {{$user->login}} Type d'utilisateur: {{$user->type}}
        <form method="post" action="{{route('cassign',['id'=>$cours->id])}}">
            <input type="hidden" name="intitule" value="{{$cours->intitule}}">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <input type="submit" value="Assigner au cours">
            @csrf
        </form>
    <br>
    @endforeach
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
