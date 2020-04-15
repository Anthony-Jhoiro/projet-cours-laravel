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

    
    const recette_id = $('#recette_id').val();
    

    // post notation :
    postNote();


    // note moyenne :

    $.ajax({
        method: 'GET',
        url: '/noteMoyenne/' + recette_id,
    })
        .done(data => { // data stocke la note moyenne arrondi à l'entier le plus proche de la recette
            for (let i = 0; i < 5; i++) { // on parcourt les tasses de la note moyenne
                currentTasse = $('.moy')[i];
                if (i < data) { // on colorie autant de tasses que la note (si note = 3, alors on colorie 3 tasses)
                    currentTasse.classList.add('text-primary');
                    currentTasse.classList.remove('text-secondary');
                } else { // on grise le reste
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
        .done(data => { // data stocke la note donnée par l'utilisateur précédemment
            if (data != "") { // si la personne est connectée, on a une note, sinon on a ""
                for (let i = 0; i < 5; i++) { // on modifie la couleur des tasses en fonction de la note
                    currentTasse = $('.mn')[i];
                    if (i < data) { // tasses colorées
                        currentTasse.classList.add('text-primary');
                        currentTasse.classList.remove('text-secondary');
                    } else { // tasses non colorées
                        currentTasse.classList.add('text-secondary');
                        currentTasse.classList.remove('text-primary');
                    }

                }
            }
            $(document).ready(() => { // une fois les modifications faites
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
                let user = data.user; // auteur du commentaire
                let date = data.date; // date d'envoi


                let div = $('#commentaires')[0];
                div.innerHTML = "<div class='col-md-12 bg-light rounded mt-4 mb-2'><h5>" + user + "</h5><h6 class='text-secondary'>" + date + "</h6><pre>" + data.commentaire + "</pre></div>" + div.innerHTML; // on ajoute le commentaire

            })
    })

    // afficher les commentaires :

    $.ajax({
        method: 'GET',
        url: '/commentaires/' + recette_id
    })
        .done(data => {
            let div = $('#commentaires')[0];

            data.forEach(currentComm => { // on rajoute chaque commentaire dans la section commentaire
                div.innerHTML += "<div class='col-md-12 bg-light rounded mt-4 mb-2'><h5>" + currentComm.user + "</h5><h6 class='text-secondary'>posté le " + currentComm.date + "</h6><pre>" + currentComm.commentaire + "</pre></div>";
            })

        })

    // fonction pour poster une note :
    function postNote() {
        $('.mn').click(e => { // lorsque l'on clique sur une tasse
            note = e.currentTarget.id;

            $.ajax({
                method: 'POST',
                url: '/note',
                data: { note: note, recette_id: recette_id } // on envoie la note avec les données nécessaires
            }).done(data => {
                for (let i = 0; i < 5; i++) { // comme pour la note moyenne, on colorise les tasses en fonction de la note contenue dans data
                    currentTasse = $('.mn')[i];
                    if (i < data) { // on colorise le nb de tasse = à la note
                        currentTasse.classList.add('text-primary');
                        currentTasse.classList.remove('text-secondary');
                    }
                    else { // on grise le reste
                        currentTasse.classList.add('text-secondary');
                        currentTasse.classList.remove('text-primary');
                    }
                }
                $(document).ready(() => { // lorsque les changements ont été effectués :
                    postNote(); // cette fonction est récursive pour pouvoir modifier sa note (c'est à dire pouvoir poster une note après avoir posté une note)
                });
            });
        });
    }
});
