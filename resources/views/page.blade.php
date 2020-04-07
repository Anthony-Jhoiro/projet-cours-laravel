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
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
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
                    <a class="nav-link" href="/recette/edition" dusk="nouvelle-recette">Nouvelle recette</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profile">Mon compte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" id="deconnexionButton">Déconnexion</a>
                </li>
                @else
                <li class="nav-item">
                    <a id="connexionLink" class="nav-link" href="/login" dusk="connexionButton">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Créer un compte</a>
                </li>
            @endauth


        </ul>
        <div class="form-inline my-2 my-lg-0">
            <input id="recherche" class="form-control mr-sm-2" type="text" placeholder="Search" class="form-control @error('nom') is-invalid @enderror" name="filtre" placeholder="rechercher" value="{{ old('nom') }}">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit" id="submit">Rechercher une recette</button>
        </div>
    </div>
</nav>

@yield('aside')
<main class="container mt-2" id="body">
    @yield('body')
</main>

<div class="modal fade " id="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content m-5" id="modalBody">
            @yield('modalContent')
        </div>
    </div>
</div>
<script>
    $(() => {
        $('#connexionLink').click(e => {
            e.preventDefault();
            $.ajax({
                url: '/login',
                method: 'get',
                success: data => {
                    console.log(data)
                    console.log($(data).find('div'))
                    $('#modalBody').html($(data).find('div.container').html());
                    $('#modal').modal({
                        show: true
                    })
                },
                error: err => console.err(err)
            })
        });

        $('#deconnexionButton').click(e => {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });
    })
</script>
@yield('js')
<script>

    $('#submit').click(() => {
        let search = $('#recherche')[0].value;
        if(search != ""){
            window.location.href = "/home?s=" + search + "&l=1";
        }
    })
</script>
</body>
</html>
