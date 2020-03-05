@extends ('page')

@section('body')
<div class="card-columns border border-primary rounded">
    @foreach($recettes as $recette)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $recette['titre'] }}</h5>
                <p class="card-text">{{ $recette['text'] }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
