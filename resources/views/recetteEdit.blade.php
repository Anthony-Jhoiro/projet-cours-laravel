@extends ('page')

@section('js_head')
    <script src="{{ asset ('js/ressources/simplemde.min.js') }}"></script>
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

    <form action="{{ url('photo') }}" action="POST" id="formulaireImage" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="file"  value="{{ old('image') }}">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </form>


    <div id="carouselImage" class="carousel slide mx-auto" style="width: 600px" data-ride="carousel">
        <ol class="carousel-indicators" id="indicators-container">
            <li data-target="#carouselImage" data-slide-to="0" class="active"></li>
        </ol>
        <div class="carousel-inner" id="imagesCarousel">
            <div class="carousel-item active ">
                <img src="/uploads/g4ASLfidi9mUs6Cu1efm2Rq4fne05e4rnTv9kvQD.jpeg" class="img-carrous d-block w-100" alt="...">
            </div>
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

@endsection

@section('js')
    <script type="text/javascript">
        let imageContainerSize = 1;
        var simplemde = new SimpleMDE();



        $(() => {
            console.log("hello");
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $('#file').change((e) => {
                // e.preventDefault();
                // let that = e.currentTarget;
                // console.log($('#file').val());
                let form = $('#formulaireImage')[0];
                let fd = new FormData(form);
                console.log(fd);
                $.ajax({
                    method: 'post',
                    url: '/photo',
                    data: fd,
                    processData: false,
                    contentType: false,
                })
                    .done((data) => {
                        console.log(data);
                        $('.carousel-item.active ').removeClass('active');
                        $('#imagesCarousel').append('<div class="carousel-item active">\n' +
                            '                <img class="d-block w-100 img-carrous" src="/'+data+'" alt="slide">\n' +
                            '            </div>');
                        $('#indicators-container').append('<li data-target="#carouselImage" data-slide-to="'+imageContainerSize+'"></li>');
                        imageContainerSize++;
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
