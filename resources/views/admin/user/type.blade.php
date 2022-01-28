@extends('modele')
@section('contents')
    @error('type')
    <p>Erreur dans le type d'utilisateur: {{$message}}</p>
    @enderror
    <form action="{{route('utype',['id'=>$user->id])}}" method="post">
        Type d'utilisateur: <select id="type" name="type">
            <option value="etudiant">Etudiant</option>
            <option value="enseignant">Enseignant</option>
            <option value="admin">Administrateur</option>
            <option value="NULL">Aucun</option>
            <option value="{{$user->type}}" selected>Ne pas changer
        </select>
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
