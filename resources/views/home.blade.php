@extends ('page')

@section('body')
<div class="d-flex border border-primary rounded">
    @foreach($recettes as $recette)
        <?php
            //print_r($recette);
        ?>
        <div class="card w-100 mt-2 mb-2">
            <div class="card-body">
                <h5 class="card-title"> {{ $recette->titre }}</h5>
                <p class="card-text">{{ $recette->text }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
