@extends('modele')
@section('title','Liste utilisateurs')
@section('contents')
    @foreach($cour as $cours)
        {{$cours->id}}: {{$cours->intitule}} <br>Crée le: {{$cours->created_at}} Modifié le : {{$cours->updated_at}}
        @if($cours->user_id==1)<form method="post" action="{{route('uassign',['id'=>$cours->id])}}">
            <input type="hidden" name="intitule" value="{{$cours->intitule}}">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <input type="submit" value="Assigner à ce cours">
            @csrf
        </form>
        @else
        <form method="post" action="{{route('uassign',['id'=>$cours->id])}}">
            <input type="hidden" name="intitule" value="{{$cours->intitule}}">
            <input type="hidden" name="user_id" value="1">
            <input type="submit" value="Désassigner">
            @csrf
        </form>@endif
        <br>
    @endforeach
    <hr />
    <p> <a href="javascript:history.back()"><button>Retour</button></a></p>

@endsection
