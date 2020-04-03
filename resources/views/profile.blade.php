@extends ('page')

@section('js_head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('body')
    <h2>Profile de : {{$user->name}}</h2>
    <ul class="list-group list-group-flush col-md-6">
        <li class="list-group-item">Adresse E-mail : {{ $user->email }}</li>
        <li class="list-group-item">Recette : {{ $recettes->count() }}</li>
        <li class="list-group-item">Followers : {{ $followers }}</li>
    </ul>

    @if($recettes->count() > 0)
        <h3 class="mt-4">Mes recettes</h3>
        <section class="row">
            @foreach($recettes as $recette)
                <div class="p-3 col-md-4">
                    <article class="card">
                        <div class="card-body">
                            <h5 class="card-title"> {{ $recette->titre }}</h5>
                            <p class="card-text">{{ $recette->parsedText }}</p>
                            <a href="recette/edition/{{$recette->id}}" class="btn btn-primary btn-edit-recette" >Éditer</a>
                            <button class="btn btn-danger btn-delete-recette" id="delete_{{ $recette->id }}">Supprimer</button>
                        </div>
                        <div class="card-footer text-muted">
                            <h6>Mis à jour le {{ $recette->formatDate }}</h6>
                        </div>
                    </article>
                </div>
            @endforeach
        </section>
    @endif

    @if($auteursSuivis->count() > 0)
        <h3 class="mt-4">Mes auteurs préférés</h3>
        <section class="row">
            @foreach($auteursSuivis as $auteur)
                <div class="p-3 col-md-3">
                    <article class="card">
                        <div class="card-body">{{ $auteur->name }}</div>
                        <div class="card-footer">
                            <button class="btn btn-danger btn-stop-follow" id="stop-follow_{{ $auteur->id }}">Supprimer</button>
                        </div>
                    </article>
                </div>
            @endforeach
        </section>
    @endif

    <script src="{{ asset ('js/pages/profile.js') }}"></script>
@endsection
