$(document).ready(function(){
    $(document).on('click',"#kontDugme", function(){
        var kontNaslov = $("#kontNaslov").val();
        var kontMail = $("#kontMail").val();
        var kontText = $("#kontText").val();

        var proverMail = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
        var greska = false;
        var notifikacija = "Greska: ";

        if(!proverMail.test(kontMail)){
            greska = true;
            notifikacija += "\nLos format za email!";
        }
        if(kontNaslov==""){
            greska = true;
            notifikacija += "\nUnesite naslov!";
        }
        if(kontText==""){
            greska = true;
            notifikacija += "\nUnesite text!";
        }

        if(!greska){
            $.ajax({
                url: "obrada/obradaKont.php",
                method: "POST",
                datatype: "JSON",
                data: {
                    poslato: true,
                    poslatoNaslov: kontNaslov,
                    poslatoMail: kontMail,
                    poslatoText: kontText
                },
                success: function(result){
                    $("#odgovor").html(`<p>Rezultat: ${result.poruka}</p>`);
                },
                error: function(xhr){
                    console.log(xhr);
                }
            });
        } else {
            alert(notifikacija);
        }
    });
});