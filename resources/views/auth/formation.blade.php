@extends('modele')
@section('title','Menu')
@section('contents')
    @foreach($formations as $formation)
        <p>{{$formation->id}}: {{$formation->intitule}} <a href="{{route('fchoixform',['id'=>$formation->id])}}"><strong><button>S'inscrire à cette formation</button></strong></a>
    @endforeach

    <p><a href="{{route('fchoixform',['id'=>0])}}"> <strong><button>Aucune formation</button></strong></a></p>
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>

@endsection
