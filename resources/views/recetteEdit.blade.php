@extends ('page')

@section('js_head')
{{--    <script src="{{ asset ('js/ressources/simplemde.min.js') }}"></script>--}}
    <link href="{{ asset('css/ressources/simplemde.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection


@section('body')

    <form id="formulairePrincipal" action="{{  ($id == -1)? route('recette.store') : route('recette.update', ['id' => $id]) }}" method="POST">
        @if($typeFormulaire == "PATCH")
        @method('patch')
        @endif

        @csrf

        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Nom de votre recette</span>
                </div>
                <input type="text" name="titre" class="form-control @error('nom') is-invalid @enderror"  placeholder="Nom de la recette" value="{{ old('nom', $recette->titre) }}">
                @error('titre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <textarea cols="30" rows="10" name="text">{{ old ('text', $recette->text) }}</textarea>
        <input class="btn btn-primary" type="submit" value="Envoyer !">
    </form>

    <form action="{{ url('photo') }}" method="POST" id="formulaireImage" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="file"  value="{{ old('image') }}">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" id="ajouter_photo" class="btn btn-secondary">Envoyer !</button>
    </form>

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" id="imagesCarousel">
            <div class="carousel-item active">
                <img class="d-block w-100" src="..." alt="First slide">
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        var simplemde = new SimpleMDE();

        $(() => {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $('#formulaireImage').submit((e) => {
                let that = e.currentTarget;
                e.preventDefault();
                var fd = new FormData($(that).get(0));
                $.ajax({
                    method: $(that).attr('method'),
                    url: $(that).attr('action'),
                    data: $(that).serialize(),
                    processData: false,
                    contentType: false,
                })
                    .done((data) => {
                        console.log(data);
                        $('#imagesCarousel').append('<div class="carousel-item active">\n' +
                            '                <img class="d-block w-100" src="/'+data+'" alt="slide">\n' +
                            '            </div>')
                    })
                    .fail((data) => {
                        console.error(data);
                    });
            });

            $('#formulairePrincipal').submit((e) => {
                e.preventDefault();
                var fd = new FormData($('#formulairePrincipal').get(0));
                $.ajax({
                    method: 'post',
                    url: '/photo',
                    data: fd,
                    processData: false,
                    contentType: false,
                })
                    .done((data) => {
                        console.log(data);
                        $('#imagesCarousel').append('<div class="carousel-item active">\n' +
                            '                <img class="d-block w-100" src="/'+data+'" alt="slide">\n' +
                            '            </div>')
                    })
                    .fail((data) => {
                        console.error(data);
                    });
            });
        });

    </script>

@endsection
