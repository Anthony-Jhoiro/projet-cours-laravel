$(() => {
    $.ajax({
        method: 'GET',
        url: '/categories'
    })
        .done(data => {
            data.forEach(currentCat => {
                $('#selectCat').append('<option class="dropdown-item categorie-item" value="' + currentCat.id + '">' + currentCat.libelle + '</option>');
            })
        })

    $('#btn-tri').click(e => {
        e.preventDefault();
        categorieId = $('#selectCat')[0].value;


        if(categorieId == -1){
            $.ajax({
                method: 'GET',
                url: '/recettes/'
            })
                .done(data => {

                    $('#recette').html("");
                    data.forEach(currentRecette => {
                        $('#recette').append('<div class="p-3 col-md-4"><article class="card"><div class="card-body"><h5 class="card-title">' +  currentRecette.titre  + '</h5><p class="card-text">' + currentRecette.text + '</p><a href="recette/' + currentRecette.id + '" class="btn btn-primary">Essayer</a> </div><div class="card-footer text-muted"> <h6>Par ' + currentRecette.name + '</h6><h6>Mis à jour le ' + currentRecette.updated_at + '</h6></div></article></div>');
                    })
                })
            return;
        }

        $.ajax({
            method: 'GET',
            url: '/recette/categorie/' + categorieId
        })
            .done(data => {

                $('#recette').html("");
                data.forEach(currentRecette => {
                    $('#recette').append('<div class="p-3 col-md-4"><article class="card"><div class="card-body"><h5 class="card-title">' +  currentRecette.titre  + '</h5><p class="card-text">' + currentRecette.text + '</p><a href="recette/' + currentRecette.id + '" class="btn btn-primary">Essayer</a> </div><div class="card-footer text-muted"> <h6>Par ' + currentRecette.name + '</h6><h6>Mis à jour le ' + currentRecette.updated_at + '</h6></div></article></div>');
                })

            })

    });
});

