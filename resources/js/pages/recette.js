$(() => {

    // Ajout du token CSRF dans les headers des requêtes AJAX
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    // Mis en place du sommaire à partir des balises 'h1', chaque tag se transforme en une entrée du sommaire
    let ids = 0;
    const summary = $('#summary');
    // Récupérations des balises h1
    const h1s = $('.recetteContent h1');
    h1s.each(function (index) {
        // Ajout d'un id à la balise pour qu'elle serve d'ancre
        $(this).attr('id', 'titre_' + ids);
        summary.append('<li><a href="#titre_' + ids + '" class="list-group-item py-1">' + $(this).text() + '</a></li>');
        ids++;
    });

    // Cliquer sur le bouton suivre permet de suivre l'auteur de la recette
    const followButton = $('#follow_btn');
    followButton.click(e => {
        const id = $('#follow_btn').attr('auteur');
        $.ajax({
            method: 'post',
            url: '/social',
            data: {id: id}
        }).done(data => {
            // Désactiver le bouton de suivit
            followButton.text("Suivit");
            followButton.attr('disabled', true);
        })
    });


    // TODO : commenter et arranger
    const recette_id = $('#recette_id'); // TODO : pas ça (input disable)
    console.log(recette_id);
    

    // post notation :
    postNote();


    // note moyenne :

    $.ajax({
        method: 'GET',
        url: '/noteMoyenne/' + recette_id,
    })
        .done(data => {
            for (let i = 0; i < 5; i++) {
                currentTasse = $('.moy')[i];
                if (i < data) {
                    currentTasse.classList.add('text-primary');
                    currentTasse.classList.remove('text-secondary');
                } else {
                    currentTasse.classList.add('text-secondary');
                    currentTasse.classList.remove('text-primary');
                }
            }
        });

    //  note user :

    $.ajax({
        method: 'GET',
        url: '/myNote/' + recette_id,
    })
        .done(data => {

            for (let i = 0; i < 5; i++) {
                currentTasse = $('.mn')[i];
                if (i < data) {
                    currentTasse.classList.add('text-primary');
                    currentTasse.classList.remove('text-secondary');
                } else {
                    currentTasse.classList.add('text-secondary');
                    currentTasse.classList.remove('text-primary');
                }

            }
            $(document).ready(() => {
                postNote(); // on appelle la fct pour pouvoir poster une note après avoir reçu la notre (la modifier)
            });
        });

    // envoyer commentaire :

    $('#envoyer-com').click(e => {
        text = $('#comm')[0].value;

        $.ajax({
            method: 'POST',
            url: '/commentaire',
            data: { comm: text, recette_id: recette_id }
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
                div.innerHTML = "<div class='col-md-12 bg-light rounded mt-4 mb-2'><h5>" + user + "</h5><h6 class='text-secondary'>" + formatDate + "</h6><pre>" + data.commentaire + "</pre></div>" + div.innerHTML;

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

    // fonction pour poster une note :
    function postNote() {
        $('.mn').click(e => {
            note = e.currentTarget.id;
            console.log(note);

            $.ajax({
                method: 'POST',
                url: '/note',
                data: { note: note, recette_id: recette_id }
            }).done(data => {
                for (let i = 0; i < 5; i++) {
                    currentTasse = $('.mn')[i];
                    if (i < data) {
                        currentTasse.classList.add('text-primary');
                        currentTasse.classList.remove('text-secondary');
                    }
                    else {
                        currentTasse.classList.add('text-secondary');
                        currentTasse.classList.remove('text-primary');
                    }
                }
                $(document).ready(() => {
                    postNote(); // cette fonction est récursive pour pouvoir modifier sa note (c'est à dire pouvoir poster une note après avoir posté une note)
                });
            });
        });
    }
});
