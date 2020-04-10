@extends ('layouts.page')

@section('js_head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('aside')

    <aside class="position-fixed mt-4 ml-2">
        <ul id="summary" class="list-group">
            <!-- fill with Js -->
        </ul>
    </aside>
@endsection

@section('body')

    <div class="container ">
        <h1 class="mx-auto text-center text-primary">{{$recette->titre}}</h1>
        <section class="row">
            @if(count($recette->assets) > 0)
                <div id="carouselImage" class="carousel slide col-md-6" data-ride="carousel">
                    <ol class="carousel-indicators" id="indicators-container">
                        @foreach($recette->assets as $index => $asset)
                            <li data-target="#carouselImage" data-slide-to="{{$index}}" class=""></li>
                        @endforeach

                    </ol>
                    <div class="carousel-inner" id="imagesCarousel">

                        @foreach($recette->assets as $index =>$asset)
                            <div class="carousel-item @if($index == 0) active  @endif">
                                <img src="/{{ $asset->url }}" alt="some picture" class="img-carrous d-block w-100">
                            </div>

                        @endforeach
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


            @endif
            <div class="col-md-6">

                <!-- Entête de la recette -->
                <div>
                    <h3>Par {{ $recette->auteurNom }}
                        @auth
                            <button class="btn btn-info" id="follow_btn" @if($estAbonne) disabled
                                    @endif auteur="{{$recette->auteur}}">
                                @if($estAbonne) Suivit @else Suivre ! @endif
                            </button>
                        @endauth
                    </h3>
                    <h6> Mis à jour le {{ $recette->formatDate }}</h6>
                </div>

                <!-- TODO : Passer en input:radio-->
                @if(Auth::check())
                    <div class="row mt-3">
                        <h4 class="col-md-7">Votre note :</h4>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="1"></i>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="2"></i>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="3"></i>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="4"></i>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="5"></i>
                    </div>
                @endif
                <div class="row mb-2">
                    <h4 class="col-md-7">Note des utilisateurs :</h4>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="1"></i>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="2"></i>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="3"></i>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="4"></i>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="5"></i>
                </div>
                <div>
                    <h4>Ingredients : </h4>
                    <!-- liste des ingrédients -->
                    <ul class="list-group list-group-flush">
                        @foreach($recette->ingredients as $ingredient)
                            <li class="list-group-item bg-light">{{ $ingredient->libelle }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </section>

        <!-- Contenue de la recette, les !! permettent d'afficher du HTML  -->
        <section class="col recetteContent m-5">{!! $recette->text !!}</section>

        <!-- Section commentaire -->
        <section class="col border-top border-primary mx-auto">
            @if(Auth::check())
                <div class="row col-md-12">
                    <h4>Laissez nous un commentaire :</h4>
                    <textarea name="commentaire" id="comm" class="border border-primary rounded" cols="147" rows="10"
                              style="resize: none;"></textarea>
                    <button class="btn btn-primary mt-1 float-right row" id="envoyer-com">envoyer</button>
                </div>
            @endif
            <div class="col-md-12 row mt-4 mb-4" id="commentaires">
            </div>
        </section>

    </div>

    <script src="{{ asset ('js/pages/recette.js') }}"></script>
@endsection
