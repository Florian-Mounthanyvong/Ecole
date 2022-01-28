@extends('modele')
@section('title','Menu')
@section('contents')
    @foreach($formations as $formation)
        <p>{{$formation->id}}: {{$formation->intitule}} <a href="{{route('cchoixform',['formation_id'=>$formation->id])}}"><strong><button>Ajouter un cours</button></strong></a>
    @endforeach


    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>

@endsection
