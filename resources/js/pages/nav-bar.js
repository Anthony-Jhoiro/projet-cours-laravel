$(() => {
    $('#connexionLink').click(e => {
        e.preventDefault();
        $.ajax({
            url: '/login',
            method: 'get',
            success: data => {
                console.log(data)
                console.log($(data).find('div'))
                $('#modalBody').html($(data).find('div.container').html());
                $('#modal').modal({
                    show: true
                })
            },
            error: err => console.err(err)
        })
    });

    $('#deconnexionButton').click(e => {
        e.preventDefault();
        document.getElementById('logout-form').submit();
    });
});


$('#search-bar').click(() => {
    let search = $('#recherche')[0].value;
    if(search != ""){
        window.location.href = "/home?s=" + search + "&l=1";
    }
});


