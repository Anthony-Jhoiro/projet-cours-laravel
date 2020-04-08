@extends ('page')

@section('aside')
    <aside class="p-3 float-left">
        <h1>{{$totalVisitors}}</h1>
        <h6>Visiteur{{($totalVisitors >1)? 's':''}}</h6>
    </aside>
@endsection

@section('body')
    <h4> Trier par catégorie : </h4>
    <div class="row">
        <select name="categorieTri" id="selectCat" class="col-md-3 border border-info rounded">
            <!-- feet by js -->
            <option value="-1">Tout</option>
        </select>
        <button class="btn btn-success ml-2" id="btn-tri">trier</button>
    </div>
    @if(count($recettesAbonnements) != 0)
        <h4 class="text-secondary mt-4">Mes Abonnements</h4>
        <section class="row rounded">
            @foreach($recettesAbonnements as $recette)
                <div class="p-3 col-md-4">
                    <article class="card">
                        <div class="card-body">
                            <h5 class="card-title"> {{ $recette->titre }}</h5>
                            <p class="card-text">{{ $recette->text }}</p>
                            <a href="recette/{{$recette->id}}" class="btn btn-primary">Essayer</a>
                        </div>
                        <div class="card-footer text-muted">
                            <h6>Par {{ $recette->auteurNom }}</h6>
                            <h6>Mis à jour le {{ $recette->dateFormat }}</h6>
                        </div>
                    </article>
                </div>
            @endforeach
        </section>
        <hr>
    @endif

    @if(count($recettesSuggerees) != 0)
        <h4 class="text-secondary">Recettes suggérées</h4>
        <section class="row rounded">
            @foreach($recettesSuggerees as $recette)
                <div class="p-3 col-md-4">
                    <article class="card">
                        <div class="card-body">
                            <h5 class="card-title"> {{ $recette->titre }}</h5>
                            <p class="card-text">{{ $recette->text }}</p>
                            <a href="recette/{{$recette->id}}" class="btn btn-primary">Essayer</a>
                        </div>
                        <div class="card-footer text-muted">
                            <h6>Par {{ $recette->auteurNom }}</h6>
                            <h6>Mis à jour le {{ $recette->dateFormat }}</h6>
                        </div>
                    </article>
                </div>
            @endforeach
        </section>
        <hr>
    @endif

    <h4 class="text-secondary">Autres recettes</h4>
    <section class="row rounded" id="recette">
        @foreach($recettes as $recette)
            <div class="p-3 col-md-4">
                <article class="card">
                    <div class="card-body">
                        <h5 class="card-title"> {{ $recette->titre }}</h5>
                        <p class="card-text">{{ $recette->text }}</p>
                        <a href="recette/{{$recette->id}}" class="btn btn-primary">Essayer</a>
                    </div>
                    <div class="card-footer text-muted">
                        <h6>Par {{ $recette->auteurNom }}</h6>
                        <h6>Mis à jour le {{ $recette->dateFormat }}</h6>
                    </div>
                </article>
            </div>

        @endforeach
    </section>

    <script src="{{ asset ('js/pages/profile.js') }}"></script>
@endsection
