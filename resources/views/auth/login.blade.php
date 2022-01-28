@extends('modele')
@section('contents')
    @error('login')
    <p>Erreur dans le login: {{$message}}</p>
    @enderror
    @error('mdp')
    <p>Erreur dans le mot de passe: {{$message}}</p>
    @enderror
    <form method="post">
        Login: <input type="text" name="login" value="{{old('login')}}">
        MDP: <input type="password" name="mdp">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
@endsection
