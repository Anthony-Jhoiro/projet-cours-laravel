
var simplemde = new SimpleMDE();



$(() => {

    let ingredientsListe = [];
    let photoUrls = [];
    let imageContainerSize = 1;

    $.ajax({
        method: 'get',
        url: '/ingredients'
    }).done(data => {
        ingredientsListe = data;
        ingredientsListe.forEach(item => {
            $('#selectIngredient').append('<option value="'+item.id+'">'+ item.libelle +'</option>')
        })
    });



    console.log("hello");
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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
                    '                <img class="d-block w-100 img-carrous" src='+data+'"/" alt="slide">\n' +
                    '            </div>');
                $('#indicators-container').append('<li data-target="#carouselImage" data-slide-to="'+imageContainerSize+'"></li>');
                imageContainerSize++;
            })
            .fail((data) => {
                console.error(data);
            });
    });



    $('#formulairePrincipal').submit((e) => {
        e.preventDefault();
        const titre = $('#titre').val();
        const text = $('#text').val();

        let categories = [];
        let checkBoxes = $('.categorie-checkbox');
        checkBoxes.each((i, e) => {
            if ($(e).is(':checked')) categories.push($(e).attr('name').split('_')[1]);
        });


        $.ajax({
            method: 'post',
            url: '/recette',
            data: {
                titre: titre,
                text: text,
                photoUrls: photoUrls,
                categories: categories
            },
        })
            .done((data) => {
                console.log(data);
            })
            .fail((data) => {
                console.log(data.responseText.message);
                $('#errorText').html(JSON.parse(data.responseText).message);
            });
    });
});
