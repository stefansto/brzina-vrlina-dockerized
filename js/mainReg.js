$(document).ready(function(){
    $(document).on('click',"#regDugme", function(){
        var regUser = $("#regUser").val();
        var regMail = $("#regMail").val();
        var regPass = $("#regPass").val();
        var regPass2 = $("#regPass2").val();

        var proveraUser = /^\S{3,32}$/;
        var proverMail = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
        var proveraPass = /^\S{8,32}$/;
        var greska = false;
        var notifikacija = "Greske:";

        if(!proveraUser.test(regUser)){
            greska = true;
            notifikacija += "\nLos format za korisnicko ime!";
        }
        if(!proverMail.test(regMail)){
            greska = true;
            notifikacija += "\nLos format za email!";
        }
        if(!proveraPass.test(regPass)){
            greska = true;
            notifikacija += "\nLos format za sifru!";
        }
        if(regPass!=regPass2){
            greska = true;
            notifikacija += "\nSifre se ne poklapaju!";
        }
        
        if(!greska){
            $.ajax({
                url: "obrada/obradaReg.php",
                method: "POST",
                datatype: "JSON",
                data: {
                    poslato: true,
                    poslatoUser: regUser,
                    poslatoMail: regMail,
                    poslatoPass: regPass,
                    poslatoPass2: regPass2
                },
                success: function(result){
                    document.location.href = "index.php";
                },
                error: function(xhr){
                    alert(xhr.responseJSON.poruka);
                }
            });
        } else {
            alert(notifikacija);
        }
    });
});