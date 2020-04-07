@extends('page')


@section('body')
    <h2 class="h1-responsive font-weight-bold text-center my-4">Contactez nous !</h2>
    <p class="text-center w-responsive mx-auto mb-5">Vous avez une question ? Nous avons une réponse ! Notre équipe
        est là pour répondre à toute vos demandes.</p>


    <!--Grid row-->
    <form class="row" id="contact-form" name="contact-form" action="/contact" method="POST">
        @csrf

        <!--Nom-->
        <div class="col-md-6">
            <div class="md-form mb-0">
                <label for="nom" class="">Votre nom</label>
                <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom">
            </div>
        </div>
        <!--/Nom-->

        <!--Prenom-->
        <div class="col-md-6">
            <div class="md-form mb-0">
                <label for="prenom" class="">Votre prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Votre Prénom">
            </div>
        </div>
        <!--/Prenom-->

        <!--Email-->
        <div class="col-md-8" >
            <div class="md-form mb-0">
                <label for="email" class="">Votre adresse Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="mail@exemple.com">
            </div>
        </div>
        <!--/Email-->

        <!--message-->
        <div class="col-md-12">
            <label for="message">Votre message</label>
            <div class="md-form">
                <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea" placeholder="Dites nous à quel point vous êtes heureux !"></textarea>
            </div>
        </div>
        <!--/message-->
        <button type="submit" class="btn btn-primary m-3">Envoyer !</button>

    </form>
    <!--Grid row-->
@endsection
