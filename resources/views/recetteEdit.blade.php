@extends ('page')

@section('js_head')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endsection


@section('body')

    <form action="{{ url('recette') }}" method="POST">
{{--            <input type="text" class="form-control  @error('nom') is-invalid @enderror" name="nom" id="nom" placeholder="Votre nom" value="{{ old('nom') }}">--}}
{{--            @error('nom')--}}
{{--            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--            @enderror--}}

        @csrf

        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Nom de votre recette</span>
                </div>
                <input type="text" name="titre" class="form-control @error('nom') is-invalid @enderror"  placeholder="Nom de la recette" value="{{ old('nom') }}">
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <textarea cols="30" rows="10" name="text"></textarea>
        <input type="submit" value="Envoyer !">
    </form>

@endsection

@section('js')
    <script>
        var simplemde = new SimpleMDE();
    </script>

@endsection
