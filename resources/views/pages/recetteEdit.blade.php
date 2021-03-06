@extends ('layouts.page')

@section('js_head')


    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection


@section('body')
    <p id="errorText" class="text-danger"></p>

    <form id="formulairePrincipal" @if($id == -1) action="{{ route('recette.store') }}" method="POST" @else
    action="{{ route('recette.update', ['id' => $id]) }}" method="PATCH" @endif>
        @if($id != -1)
            <input type="text" disabled hidden value="{{$id}}" id="recetteId">
        @endif



        @csrf

        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Nom de votre recette</span>
                </div>
                <input type="text" name="titre" id="titre" class="form-control @error('nom') is-invalid @enderror"
                       placeholder="Nom de la recette" value="{{ old('nom', $recette->titre) }}">
                @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <textarea cols="30" rows="10" name="text" id="text">{{ old ('text', $recette->text) }}</textarea>
        <div class="d-flex flex-row mb-2 flex-wrap">
            @foreach($categories as $key => $value)
                <div class="p-2">
                    <label for="chkCat_{{ $value->id }}" class="checklist-element">
                        <input class="d-none categorie-checkbox" type="checkbox" name="chkCat_{{$value->id}}"
                               id="chkCat_{{$value->id}}"
                               @if(in_array ($value->id, $categoriesSelectionnes)) checked @endif
                        >
                        <span class="badge badge-pill badge-light checkbox-label">
                        {{$value->libelle}}
                    </span>
                    </label>
                </div>
            @endforeach
        </div>

        <section class="col-md-6">
            <h3 class="d-inline-block">Liste de courses :</h3>
            <div class="dropdown d-inline-block">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropIngredients"
                        data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    Les ingrédients
                </button>
                <div class="dropdown-menu" aria-labelledby="dropIngredients">
                    <input type="text" id="ingredientValue" placeholder="ingredient">
                    <button class="btn btn-success" id="ajouterIngredient">Ajouter</button>
                    <ul id="selectIngredient">
                    </ul>
                </div>
            </div>
            <ul class="list-group list-group-flush" id="listeIngredient">
            </ul>
        </section>

        <input class="btn btn-primary m-3" type="submit" value="Envoyer !">
    </form>



    <form action="{{ url('photo') }}" action="POST" id="formulaireImage" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="file"
                   value="{{ old('image') }}">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </form>



    <div id="carouselImage" class="carousel slide mx-auto" style="width: 600px" data-ride="carousel">
        <ol class="carousel-indicators" id="indicators-container">
        </ol>
        <div class="carousel-inner" id="imagesCarousel">
{{--            @foreach($assets as $asset)--}}
{{--                <div class="carousel-item asset-item ">--}}
{{--                    <img src="/{{ $asset->url }}" class="img-carrous d-block w-100" alt="...">--}}
{{--                </div>--}}
{{--            @endforeach--}}

        </div>
        <a class="carousel-control-prev" href="#carouselImage" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselImage" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <script src="{{ asset ('js/ressources/simplemde.min.js') }}"></script>
    <script src="{{ asset ('js/pages/recetteEdit.js') }}"></script>

@endsection


