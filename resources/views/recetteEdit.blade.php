@extends ('page')

@section('js_head')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endsection


@section('body')
{{--    <div class="container">--}}
{{--        <div class="row card text-white bg-dark">--}}
{{--            <h4 class="card-header">Contactez-moi</h4>--}}
{{--            <div class="card-body">--}}
{{--                <form action="{{ url('recette') }}" method="{{ $typeFormulaire }}">--}}
{{--                    @csrf--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="text" class="form-control  @error('nom') is-invalid @enderror" name="nom" id="nom" placeholder="Votre nom" value="{{ old('nom') }}">--}}
{{--                        @error('nom')--}}
{{--                        <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" id="email" placeholder="Votre email" value="{{ old('email') }}">--}}
{{--                        @error('email')--}}
{{--                        <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <textarea class="form-control  @error('message') is-invalid @enderror" name="message" id="message" placeholder="Votre message">{{ old('message') }}</textarea>--}}
{{--                        @error('message')--}}
{{--                        <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <button type="submit" class="btn btn-secondary">Envoyer !</button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <form action="{{ url('recette') }}" method="POST">
        <div class="form-group">
            <input type="text" class="form-control  @error('nom') is-invalid @enderror" name="nom" id="nom" placeholder="Votre nom" value="{{ old('nom') }}">
            @error('nom')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <textarea cols="30" rows="10"></textarea>
        <input type="submit" value="Envoyer !">
    </form>





@endsection

@section('js')
    <script>
        var simplemde = new SimpleMDE();
    </script>

@endsection
