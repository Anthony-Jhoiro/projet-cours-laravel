@extends ('page')

@section('aside')

    <aside class="position-fixed mt-4 ml-2">
        <ul id="summary" class="list-group">

        </ul>
    </aside>
@endsection

@section('body')

        <h1 class="mx-auto text-center recetteTitre">{{$recette->titre}}</h1>

        <div class="row">
            <div class="col-md-6">
                <!-- TODO : Les images -->
            </div>
            <div class="col-md-6">
                <div><!-- TODO : Infos sur l'auteur --></div>
                <!-- TODO : liste des ingrédients -->
            </div>
        </div>

        <div class="col recetteContent">{!! $recette->text !!}</div>

{{--        <div class="row">--}}
{{--            <div class="col-md-3">--}}
{{--                <div class="border-right border-primary ml-2">--}}
{{--                    <h6 class="mx-auto text-center">ingredients : </h6>--}}
{{--                    <ul class="list-group list-group-flush">--}}
{{--                        @foreach($recette->ingredients as $ingredient)--}}
{{--                            <li class="list-group-item bg-light">{{ $ingredient }}</li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--        <div class="row bg-secondary">--}}
{{--            <h6 class="col-md-6"> par {{ $recette->auteur }}</h6>--}}
{{--            <h6 class="text-right col-md-6">mis à jour le {{ $recette->updated_at }}</h6>--}}
{{--        </div>--}}

    <script>
        $(() => {
            let ids = 0;
            let summary = $('#summary');
            h1s = $('.recetteContent h1');
            h1s.each(function(index) {
                $(this).attr('id', 'titre_'+ids);
                summary.append('<li><a href="#titre_'+ids+'" class="list-group-item py-1">'+$(this).text()+'</a></li>')
                ids++;
            });
        });

    </script>
@endsection
