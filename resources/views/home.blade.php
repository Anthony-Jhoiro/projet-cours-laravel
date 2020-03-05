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
                <h6 class="float-left"> par {{ $recette->auteur }}</h6>
                <h6 class="float-right">mis à jour le {{ $recette->updated_at }}</h6>
            </div>
        </div>
    @endforeach
</div>
@endsection
