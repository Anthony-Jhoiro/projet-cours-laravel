
$(() => {
    // Ajout du token CSRF dans les headers des requêtes AJAX
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    // Cliquer sur un bouton pour arrêter de suivre un utilisateur
    $('.btn-stop-follow').click(function(e) {

        let id = $(this).attr('id').split('stop-follow_')[1];
        // id de la personne à arrêter de suivre
        $.ajax({
            method: "delete",
            url:  '/social/'+id
        }).done(() => {
            alert("Vous avez bien arrêté de suivre cette utilisateur.");
            document.location.reload(true);
        })
    });

    // Cliquer sur un bouton pour supprimer une recette
    $('.btn-delete-recette').click(function(e) {
        let id = $(this).attr('id').split('delete_')[1];
        // id de la recette à supprimer
        // La requête échoue si la recette à supprimer n'a pas été écrite par l'utilisateur
        $.ajax({
            method: "delete",
            url:  '/recette/'+id
        }).done(() => {
            alert("La recette a bien été supprimée.");
            document.location.reload(true);
        })
    });
});
