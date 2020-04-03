@component('mail::message')
# Hello !

{{ $auteur->name }} a sorti une nouvelle recette : {{ $recette->titre }} !

Nous attendons impatiemment votre retour !

@component('mail::button', ['url' => 'http://localhost:8000/recette/'.$recette->id])
Consulter la recette
@endcomponent

Merci,
Toute l'équipe Cassrollton
@endcomponent
