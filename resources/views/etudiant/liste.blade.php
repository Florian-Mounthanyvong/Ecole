@extends('modele')
@section('title','Menu')
@section('contents')
    @foreach($cour as $cours)
        <p>{{$cours->id}}: {{$cours->intitule}}
            <br>Enseignant assigné:
            @if($cours->user_id==1)Personne
        @else{{$cours->user->nom}} {{$cours->user->prenom}}
        @endif
        @if(!Auth::user()->cours()->find($cours->id))
        <form method="post" action="{{route('eassign',['id'=>$cours->id])}}">
            <input type="hidden" name="id" value="{{$cours->id}}">
            <input type="submit" value="S'inscrire à ce cours">
            @csrf
        </form>
        @else
            <form method="post" action="{{route('eassign',['id'=>$cours->id])}}">
                <input type="hidden" name="id" value="{{$cours->id}}">
                <input type="submit" value="Se désinscrire de ce cours">
                @csrf
            </form>
            @endif
        <hr />
    @endforeach

    <p><a href="/etudiant/cours"><button>Tout voir</button></a></p>
    <a href="/etudiant/inscrit"><button>Voir les cours où vous êtes inscrit </button></a> <br>
    <a href="/etudiant/cours/search"><button>Rechercher un cours spécifique</button></a>
    <hr />
    <p> <a href="/etudiant"><button> Retour au menu principal</button></a></p>

@endsection
