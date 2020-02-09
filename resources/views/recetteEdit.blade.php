@extends ('page')

@section('js_head')
    <script src="{{ asset ('js/simplemde.min.js') }}"></script>
    <link href="{{ asset('css/simplemde.min.css') }}" rel="stylesheet">
@endsection


@section('body')

    <form action="{{  ($id == -1)? route('recette.store') :route('recette.update', ['id' => $id]) }}" method="POST">
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

@endsection

@section('js')
    <script>
        var simplemde = new SimpleMDE();
    </script>

@endsection
