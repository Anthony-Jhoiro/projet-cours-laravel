
$(() => {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $('.btn-stop-follow').click(function(e) {
        let id = $(this).attr('id').split('stop-follow_')[1];
        $.ajax({
            method: "delete",
            url:  '/social/'+id
        }).done(() => {
            alert("Vous avez bien arrêté de le suivre.");
            // TODO : Supprimer de la liste
        })
    });

    $('.btn-delete-recette').click(function(e) {
        let id = $(this).attr('id').split('delete_')[1];
        $.ajax({
            method: "delete",
            url:  '/recette/'+id
        }).done(() => {
            alert("La recette a bien été supprimée.");
            // TODO : Supprimer de la liste
        })
    });
});
