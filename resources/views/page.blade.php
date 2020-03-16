<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Casrollton</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}


    <!-- Javascript -->
    @yield('js_head')

{{--    <script src="{{ asset ('js/ressources/popper.min.js') }}"></script>--}}
{{--    <script src="{{ asset ('js/ressources/jquery.min.js') }}"></script>--}}
{{--    <script src="{{ asset ('js/ressources/bootstrap.min.js') }}"></script>--}}

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>


</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="/">Cassrollton</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="/home">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/recette/edition">Nouvelle recette</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Mon compte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Déconnexion</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="/login">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Créer un compte</a>
                </li>
            @endauth


        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" class="form-control @error('nom') is-invalid @enderror" name="nom" id="nom" placeholder="Votre nom" value="{{ old('nom') }}">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Rechercher une recette</button>
        </form>
    </div>
</nav>
@yield('aside')
<div class="container mt-2" id="body">
    @yield('body')
</div>
@yield('js')
</body>
</html>
