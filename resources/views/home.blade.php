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
            <div class="card-footer text-muted">
                <p class="float-left"> par {{ $recette->auteur }}</p>
                <p class="float-right">mis à jour le {{ $recette->updated_at }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
