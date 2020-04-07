@extends ('page')

@section('js_head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('js_head')


    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('aside')

    <aside class="position-fixed mt-4 ml-2">
        <ul id="summary" class="list-group">
            <!-- fill with Js -->
        </ul>
    </aside>
@endsection

@section('body')

    <div class="container ">
        <h1 class="mx-auto text-center text-primary">{{$recette->titre}}</h1>
        <section class="row">
            @if(count($recette->assets) > 0)
                <div id="carouselImage" class="carousel slide col-md-6" data-ride="carousel">
                    <ol class="carousel-indicators" id="indicators-container">
                        @foreach($recette->assets as $index => $asset)
                            <li data-target="#carouselImage" data-slide-to="{{$index}}" class=""></li>
                        @endforeach

                    </ol>
                    <div class="carousel-inner" id="imagesCarousel">

                        @foreach($recette->assets as $index =>$asset)
                            <div class="carousel-item @if($index == 0) active  @endif">
                                <img src="/{{ $asset->url }}" alt="some picture" class="img-carrous d-block w-100">
                            </div>

                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselImage" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselImage" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>


            @endif
            <div class="col-md-6">
                <div>
                    <h3>Par {{ $recette->auteurNom }} @auth <button class="btn btn-info" id="follow_btn" auteur="{{$recette->auteur}}">Suivre !</button> @endauth</h3>
                    <h6> Mis à jour le {{ $recette->formatDate }}</h6>
                </div>
                @if(Auth::check())
                    <div class="row mt-3">
                        <h4 class="col-md-7">Votre note :</h4>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="1"></i>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="2"></i>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="3"></i>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="4"></i>
                        <i class="fas fa-mug-hot text-secondary mr-1 mn" id="5"></i>
                    </div>
                @endif
                <div class="row mb-2">
                    <h4 class="col-md-7">note des utilisateurs :</h4>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="1"></i>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="2"></i>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="3"></i>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="4"></i>
                    <i class="fas fa-mug-hot text-secondary mr-1 moy" value="5"></i>
                </div>
                <div>
                    <h4>Ingredients : </h4>
                    <ul class="list-group list-group-flush">
                        @foreach($recette->ingredients as $ingredient)
                            <li class="list-group-item bg-light">{{ $ingredient->libelle }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </section>


        <section class="col recetteContent m-5">{!! $recette->text !!}</section>

        <section class="col border-top border-primary mx-auto">
            @if(Auth::check())
                <div class="row col-md-12">
                    <h4>Laissez nous un commentaire :</h4>
                    <textarea name="commentaire" id="comm" class="border border-primary rounded" cols="147" rows="10" style="resize: none;"></textarea>
                    <button class="btn btn-primary mt-1 float-right row" id="envoyer-com">envoyer</button>
                </div>
            @endif
            <div class="col-md-12 row mt-4 mb-4" id="commentaires">
            </div>
        </section>


    </div>


    <script>
        $(() => {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            let ids = 0;
            let summary = $('#summary');
            h1s = $('.recetteContent h1');
            h1s.each(function (index) {
                $(this).attr('id', 'titre_' + ids);
                summary.append('<li><a href="#titre_' + ids + '" class="list-group-item py-1">' + $(this).text() + '</a></li>')
                ids++;
            });

            $('#follow_btn').click(e => {
                const id = $('#follow_btn').attr('auteur');
                let fd = new FormData();
                console.log('id => '+id)
                fd.append('id', id);
                $.ajax({
                    method: 'post',
                    url: '/social',
                    data: { id: id }
                }).done(data => {
                })

            });
            recette_id = window.location.href.split('/').pop();

            // post notation : 
            $(document).ready(() => {
                $('.mn').click(e => {
                    note = e.currentTarget.id;
                    console.log(note);

                    $.ajax({
                        method: 'POST',
                        url: '/note',
                        data: {note: note, recette_id: recette_id}
                    }).done(data => { 
                        for(let i = 0; i < 5; i++){
                            currentTasse = $('.mn')[i];
                            if(i < data){
                                currentTasse.classList.add('text-primary');
                                currentTasse.classList.remove('text-secondary');
                            } 
                            else {
                                currentTasse.classList.add('text-secondary');
                                currentTasse.classList.remove('text-primary');
                            }
                        } 
                    })
                });
            });
            

            // note moyenne :

            $.ajax({
                method: 'GET',
                url: '/noteMoyenne/' + recette_id,
            })
            .done(data => {                
                for(let i = 0; i < 5; i++){
                    currentTasse = $('.moy')[i];
                    if(i < data){
                        currentTasse.classList.add('text-primary');
                        currentTasse.classList.remove('text-secondary');
                    } else{
                        currentTasse.classList.add('text-secondary');
                        currentTasse.classList.remove('text-primary');
                    }
                }
            });

            // //  note user :

            // $.ajax({
            //     method: 'GET',
            //     url: '/myNote/' + recette_id,
            // })
            // .done(data => {    
                            
            //     for(let i = 0; i < 5; i++){
            //         currentTasse = $('.mn')[i];
            //         if(i < data){
            //             currentTasse.classList.add('text-primary');
            //             currentTasse.classList.remove('text-secondary');
            //         } else{
            //             currentTasse.classList.add('text-secondary');
            //             currentTasse.classList.remove('text-primary');
            //         }
                    
            //     }
            // });

            // envoyer commentaire :

            $('#envoyer-com').click(e => {
                text = $('#comm')[0].value;
                
                $.ajax({
                    method: 'POST',
                    url: '/comm',
                    data: {comm: text, recette_id: recette_id}
                })
                .done(data => {
                    let user = data.user;
                    
                    let now = new Date();
                    let year = now.getFullYear();
                    let day = now.getDate();
                    months = [
                        'janvier',
                        'février',
                        'mars',
                        'avril',
                        'mai',
                        'juin',
                        'août',
                        'septembre',
                        'octobre',
                        'novembre',
                        'décembre'
                    ]
                    let month = months[now.getMonth()];
                    let hour = now.getHours();
                    let minute = now.getMinutes();

                    let formatDate = 'posté le ' + day + ' ' + month + ' ' + year + ' à ' + hour + ':' + minute;
                    console.log(formatDate);
                    
                    
                    let div = $('#commentaires')[0];
                    div.innerHTML = "<div class='col-md-12 bg-light rounded mt-4 mb-2'><h5>" + user + "</h5><h6 class='text-secondary'>" + formatDate + "</h6><pre>" + data.commentaire + "</pre></div>" +  div.innerHTML;                    
                    
                })
            })

            // afficher les commentaires :

            $.ajax({
                method: 'GET',
                url: '/commentaires/' + recette_id
            })
            .done(data => {                
                let div = $('#commentaires')[0];
                
                data.forEach(currentComm => {
                    div.innerHTML += "<div class='col-md-12 bg-light rounded mt-4 mb-2'><h5>" + currentComm.user + "</h5><h6 class='text-secondary'>posté le " + currentComm.date + "</h6><pre>" + currentComm.commentaire + "</pre></div>"; 
                })
                
            })


        });

    </script>
@endsection
