$(() => {


    /**
     * Remplie la page avec les recettes données en paramètres
     * @param recettes
     */
    function fillPageWhith(recettes) {
        $('#recette').html("");
        recettes.forEach(currentRecette => {
            $('#recette').append('<div class="p-3 col-md-4"><article class="card"><div class="card-body"><h5 class="card-title">' + currentRecette.titre + '</h5><p class="card-text">' + currentRecette.text + '</p><a href="recette/' + currentRecette.id + '" class="btn btn-primary">Essayer</a> </div><div class="card-footer text-muted"> <h6>Par ' + currentRecette.auteurNom + '</h6><h6>Mis à jour le ' + currentRecette.updated_at + '</h6></div></article></div>');
        })
    }

    // Quand on clique sur le bouton "trier" recherche puis affiche des recettes de la catégorie sélectionnée
    // Si aucune catégorie n'est spécifié, on renvoie des recettes de n'importe quelle catégories
    $('#btn-tri').click(e => {
        e.preventDefault();
        const categorieId = $('#selectCat')[0].value;
        if(categorieId === -1){
            categorieId = "";
        }
        const url = '/recettes/categorie/' + categorieId;
        
        $.ajax({
            method: 'GET',
            url: url
        }).done(fillPageWhith);

    });
});

