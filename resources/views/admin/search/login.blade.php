@extends('modele')
@section('contents')
    @error('login')
    <p>Erreur dans le login: {{$message}}</p>
    @enderror
    <form action="" method="post">
        Login: <input type="text" name="login" value="{{old('login')}}">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
