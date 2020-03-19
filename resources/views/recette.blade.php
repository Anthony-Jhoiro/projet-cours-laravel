@extends ('page')

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
                <div>
                    <h3>Par {{ $recette->auteurNom }}</h3>
                    <h6> Mis à jour le {{ $recette->formatDate }}</h6>
                </div>
                <div>
                    <h4>Ingredients : </h4>
                    <ul class="list-group list-group-flush">
                        @foreach($recette->ingredients as $ingredient)
                            <li class="list-group-item bg-light">{{ $ingredient }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </section>


        <section class="col recetteContent m-5">{!! $recette->text !!}</section>


    </div>


    <script>
        $(() => {
            let ids = 0;
            let summary = $('#summary');
            h1s = $('.recetteContent h1');
            h1s.each(function (index) {
                $(this).attr('id', 'titre_' + ids);
                summary.append('<li><a href="#titre_' + ids + '" class="list-group-item py-1">' + $(this).text() + '</a></li>')
                ids++;
            });
        });

    </script>
@endsection
