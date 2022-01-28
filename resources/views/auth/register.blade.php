@extends('modele')
@section('contents')
    @error('nom')
    <p>Erreur dans le nom: {{$message}}</p>
    @enderror
    @error('prenom')
    <p>Erreur dans le prenom: {{$message}}</p>
    @enderror
    @error('login')
    <p>Erreur dans le login: {{$message}}</p>
    @enderror
    @error('formation_id')
    <p>Erreur dans la formation: {{$message}}</p>
    @enderror
    @error('mdp')
    <p>Erreur dans le mot de passe: {{$message}}</p>
    @enderror

    <p>Enregistrement</p>
    @if($formation!=null)
    <form method="post"action="{{route('fchoix',['id'=>$formation->id])}}">
        Nom: <input type="text" name="nom" value="{{old('nom')}}">
        Prénom: <input type="text" name="prenom" value="{{old('prenom')}}">
        <input type="hidden" name="formation_id" value="{{$formation->id}}">
        Login: <input type="text" name="login" value="{{old('login')}}">
        MDP: <input type="password" name="mdp">
        Confirmation MDP: <input type="password"
                                 name="mdp_confirmation">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    @else
        <form method="post"action="">
            Nom: <input type="text" name="nom" value="{{old('nom')}}">
            Prénom: <input type="text" name="prenom" value="{{old('prenom')}}">
            <input type="hidden" name="formation_id" value="{{old('formation_id')}}">
            Login: <input type="text" name="login" value="{{old('login')}}">
            MDP: <input type="password" name="mdp">
            Confirmation MDP: <input type="password"
                                     name="mdp_confirmation">
            <input type="submit" value="Envoyer">
            @csrf
        </form>
    @endif
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
