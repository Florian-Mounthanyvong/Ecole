@extends('modele')
@section('contents')

    @error('mdp')
    <p>Erreur dans le mot de passe: {{$message}}</p>
    @enderror
    @error('mdp_confirmation')
    <p>Erreur dans la confirmation du mot de passe: {{$message}}</p>
    @enderror
    <form method="post">
        Nouveau mot de passe: <input type="password" name="mdp">
        Confirmation MDP: : <input type="password"
                                   name="mdp_confirmation">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
