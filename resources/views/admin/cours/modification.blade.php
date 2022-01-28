@extends('modele')
@section('title','Ajout')
@section('contents')

    @error('intitule')
    <p>Erreur dans l'intitulé' : {{$message}}</p>
    @enderror

    <form method="post" action="{{route('cedit',['id'=>$cour->id])}}">
        Intitulé: <input type="text" name="intitule" value="{{$cour->intitule}}"> <br>
        Formation:
        <select id="formation_id" name="formation_id">
            @foreach ($formations as $formation)
                <option value="{{ $formation->id }}">{{$formation->intitule}}
            @endforeach
            <option value="{{$cour->formation_id}}" selected>Ne pas changer
            </option>
        </select>
        <input type="submit" value="Envoyer">
        @csrf
    </form>
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>
@endsection
