<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <title>@yield('title')</title>
</head>
<body>
@guest()
    <a href="{{route('login')}}"><button>Connexion</button></a>
    <a href="/formations"><button>Inscription</button></a>
    <a href="/bloque"><button>Bloqué? Changez le mot de passe du compte admin</button></a>
@endguest
@auth
    <a href="{{route('logout')}}"><button>Déconnexion</button></a>
    <p>Bonjour {{ Auth::user()->prenom}} {{ Auth::user()->nom}} </p>
    <p> <a href="/compte"><button>Modifier son compte</button></a></p>
@endauth

@if( session()->has('etat'))
    <p class="etat">{{session()->get('etat')}}</p>
@endif
<hr />
@yield('contents')
</body>
</html>
