var simplemde = new SimpleMDE();


$(() => {

    let ingredientsListe = [];
    let ingredientsListeForRecette = [];
    let photoUrls = [];
    let imageContainerSize = 0;


    let formulaire = $('#formulairePrincipal');
    let id = $('#recetteId').val();
    let method = formulaire.attr('method');

    if (method != 'POST') {
        $.ajax({
            method: 'get',
            url: '/assets/recette/'+id
        }).done(data => {
            data.forEach(e => {
                photoUrls.push(e.url);
                $('.carousel-item.active ').removeClass('active');
                $('#imagesCarousel').append('<div class="carousel-item active">\n' +
                    '                <img class="d-block w-100 img-carrous" src="/' + e.url + '" alt="slide">\n' +
                    '            </div>');
                $('#indicators-container').append('<li data-target="#carouselImage" data-slide-to="' + imageContainerSize + '"></li>');
            })
        });

        $.ajax({
            method: 'get',
            url: '/ingredients/recette/'+id
        }).done(data => {
            console.log(data)
            data.forEach(e => {
                ingredientsListeForRecette.push({ libelle: e.libelle, id: e.libelle });
                $('#listeIngredient').append(" <li class=\"list-group-item p-1\">" + e.libelle + "</li>");
            });
        });
    }

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    let addEventOnDropDownItems = () => {

        $('.ingredient-item').click(function() {
            ingredientsListeForRecette.push({ libelle: $(this).text(), id: $(this).attr('value') });
            $('#listeIngredient').append(" <li class=\"list-group-item p-1\">" + $(this).text() + "</li>");
        });
    };

    $.ajax({
        method: 'get',
        url: '/ingredients'
    }).done(data => {
        ingredientsListe = data;
        ingredientsListe.forEach(item => {
            $('#selectIngredient').append('<li class="dropdown-item ingredient-item" value="' + item.id + '">' + item.libelle + '</li>')
        });
        addEventOnDropDownItems();
    });



    $('#ajouterIngredient').click((e) => {
        e.preventDefault();
        let text = $('#ingredientValue').val();

        if (text.length > 0 && ingredientsListe.filter(v => v.libelle.toUpperCase() === text.toUpperCase()).length === 0) {

            $.ajax({
                method: 'post',
                url: '/ingredients',
                data: {libelle: text}
            }).done(data => {
                if (data)
                {
                    ingredientsListe = data;
                    $('#selectIngredient').html("");
                    ingredientsListe.forEach(item => {
                        $('#selectIngredient').append('<li class="dropdown-item ingredient-item" value="' + item.id + '">' + item.libelle + '</li>');
                    });
                    addEventOnDropDownItems();
                }

            })

        }
    });

    $('#file').change((e) => {
        // e.preventDefault();
        // let that = e.currentTarget;
        // console.log($('#file').val());
        let form = $('#formulaireImage')[0];
        console.log(form);
        let fd = new FormData(form);
        console.log(fd);
        $.ajax({
            method: 'post',
            url: '/photo',
            data: fd,
            processData: false,
            contentType: false,
        })
            .done((data) => {
                console.log(data);
                photoUrls.push(data);
                $('.carousel-item.active ').removeClass('active');
                $('#imagesCarousel').append('<div class="carousel-item active">\n' +
                    '                <img class="d-block w-100 img-carrous" src="/' + data + '" alt="slide">\n' +
                    '            </div>');
                $('#indicators-container').append('<li data-target="#carouselImage" data-slide-to="' + imageContainerSize + '"></li>');
                imageContainerSize++;
            })
            .fail((data) => {
                console.error(data);
            });
    });


    formulaire.submit((e) => {
        e.preventDefault();
        const titre = $('#titre').val();
        const text = $('#text').val();

        let categories = [];
        let checkBoxes = $('.categorie-checkbox');
        checkBoxes.each((i, e) => {
            if ($(e).is(':checked')) categories.push($(e).attr('name').split('_')[1]);
        });


        $.ajax({
            method: formulaire.attr('method'),
            url: (method === 'PATCH')? '/recette/'+id : '/recette',
            data: {
                titre: titre,
                text: text,
                photoUrls: photoUrls,
                categories: categories,
                ingredients: (ingredientsListeForRecette.map(e => e.id))
            },
        })
            .done((data) => {
                if (data === 'success') {
                    document.location.href="/home";
                }
            })
            .fail((data) => {
                console.log(data.responseText.message);
                $('#errorText').html(JSON.parse(data.responseText).message);
            });
    });
});
