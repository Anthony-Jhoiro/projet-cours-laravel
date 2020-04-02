@extends ('page')

@section('aside')
    <aside class="p-3 float-left">
        <h1>{{$totalVisitors}}</h1>
        <h6>Visiteur{{($totalVisitors >1)? 's':''}}</h6>
    </aside>
@endsection

@section('body')
<div class="row rounded">
    @foreach($recettes as $recette)
        <div class="p-3 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> {{ $recette->titre }}</h5>
                    <p class="card-text">{{ $recette->text }}</p>
                    <a href="recette/{{$recette->id}}" class="btn btn-primary">Essayer</a>
                </div>
                <div class="card-footer text-muted">
                    <h6>Par {{ $recette->auteur }}</h6>
                    <h6>Mis à jour le {{ $recette->dateFormat }}</h6>
                </div>
            </div>
        </div>

    @endforeach
</div>
@endsection
