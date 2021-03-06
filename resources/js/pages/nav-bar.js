$(() => {

    // Quand on clique sur le bouton "Connexion", ouvre une modale contenant
    // le formulaire de connexion d la page /login
    $('#connexionLink').click(e => {
        e.preventDefault();
        $.ajax({
            url: '/login',
            method: 'get',
            success: data => {
                // Ouverture de la modale avec le contenue de la page de login
                $('#modalBody').html($(data).find('div.container').html());
                $('#modal').modal({
                    show: true
                })
            },
            error: err => console.err(err)
        })
    });

    // Déconnecte l'utilisateur (évite de devoir porter un formulaire supplémentaire dans le html
    $('#deconnexionButton').click(e => {
        e.preventDefault();
        document.getElementById('logout-form').submit();
    });
});





