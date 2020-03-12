@extends ('page')

@section('body')
    <?php
        print_r($recette);
    ?>
    
    <div class="container bg-light">
        <h3 class="mx-auto text-center">{{$recette->titre}}</h3>
        <div class="row">
            <div class="col-md-3">
                <div class="border-right border-primary ml-2">
                    <h6 class="mx-auto text-center">ingredients : </h6>
                    <ul class="list-group list-group-flush">
                        @foreach($recette->ingredients as $ingredient)
                            <li class="list-group-item bg-light">{{ $ingredient }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <p class="col">{{ $recette->text }}</p>
        </div>
    </div>
@endsection