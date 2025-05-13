$(document).ready(function(){
    $(document).on('click',"#logDugme", function(){
        var logUser = $("#logUser").val();
        var logPass = $("#logPass").val();

        var proveraUser = /^\S{3,32}$/;
        var proveraPass = /^\S{8,32}$/;
        var greska = false;
        notifikacija = "Greske: ";

        if(!proveraUser.test(logUser)){
            greska = true;
            notifikacija += "\nLos format za korisnicko ime!";
        }
        if(!proveraPass.test(logPass)){
            greska = true;
            notifikacija += "\nLos format za sifru!";
        }
        
        if(!greska){
            $.ajax({
                url: "obrada/obradaLog.php",
                method: "POST",
                datatype: "JSON",
                data: {
                    poslato: true,
                    poslatoUser: logUser,
                    poslatoPass: logPass
                },
                success: function(result){
                    if(result.poruka == "Good")document.location.href = "index.php";
                    else{
                        $("#greska").html(`<p>Rezultat: ${result.poruka}</p>`);
                    }
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