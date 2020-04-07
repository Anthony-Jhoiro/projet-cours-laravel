@component('mail::message')
    ## Prise de contact sur Cassrollton

    Réception d'une prise de contact avec les éléments suivants :

    - Nom : {{ $contactInfos['nom'] }}
    - Prénom : {{ $contactInfos['prenom'] }}
    - Adresse Email : {{ $contactInfos['email'] }}

    {{ $contactInfos['message'] }}

    L'équipe Cassrollton
@endcomponent
