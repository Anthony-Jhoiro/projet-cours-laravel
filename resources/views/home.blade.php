@extends ('page')

@section('body')
<div class="d-flex flex-column border border-primary rounded">
    @for($i = 0; $i < count($recettes); $i++)
        @if($i % 2 == 0)
        <div class="d-flex">
        @endif
        <div class="card mt-2 mb-2 ml-1 mr-1">
            <div class="card-body">
                <h5 class="card-title"> {{ $recettes[$i]->titre }}</h5>
                <p class="card-text">{{ $recettes[$i]->text }}</p>
                <a href="recette/{{$recettes[$i]->id}}" class="btn btn-primary">Essayer</a>
            </div>
            <div class="card-footer text-muted">
                <h6 class="float-left"> par {{ $recettes[$i]->auteur }}</h6>
                <h6 class="float-right">mis à jour le {{ $recettes[$i]->updated_att }}</h6>
            </div>
        </div>
        @if($i % 2 == 1)
        </div>
        @endif
    @endfor
</div>
@endsection
