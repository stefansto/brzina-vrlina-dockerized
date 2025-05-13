$(document).on('click', '.glasaj', function(e){
    e.preventDefault();
    let idAnkete = $(this).data('id');
    let idKorisnik = $(this).data('korisnik');
    let brojRadio = "odgovor"+idAnkete;
    brojRadio = "input[name="+brojRadio+"]:checked";
    let izabranOdgovor = $(brojRadio).val();

    if(izabranOdgovor!=null){
        $.ajax({
            url: "obrada/obradaAnketa.php",
            method: "POST",
            datatype: "JSON",
            data: {
                poslatoGlasaj: true,
                poslatoAnketa: idAnkete,
                poslatoKorisnik: idKorisnik,
                poslatoOdgovor: izabranOdgovor
            },
            success: function(result){
                $('#ispisTabele').html(result);
            },
            error: function(xhr){
                console.log(xhr);
            }
        });
    } else {
        console.log("Niste izabrali");
        $('#ispisTabele').html("<p>Izaberite odgovor!</p>");
    }
});

$(document).on('click', '.rezultati', function(e){
    e.preventDefault();
    let idAnkete = $(this).data('id');
    
    $.ajax({
        url: "obrada/obradaAnketa.php",
        method: "POST",
        datatype: "JSON",
        data: {
            poslatoRezultat: true,
            poslatoAnketa: idAnkete
        },
        success: function(result){
            $('#ispisTabele').html(result);
        },
        error: function(xhr){
            console.log(xhr);
        }
    });
});