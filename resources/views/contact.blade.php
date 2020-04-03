@extends('page')


@section('body')
    <form action="/contact" class="card" method="post">
        @csrf

        <h3 class="card-title">Contactez nous !</h3>
        <div class="card-body">
            <input type="text" name="nom" placeholder="Nom">
            <input type="mail" name="email" placeholder="Nom">
            <input type="text" name="message" placeholder="Dites nous à quel point vous êtes heureux">
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Envoyer !</button>
        </div>
    </form>
@endsection
