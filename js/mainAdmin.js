$(document).ready(function(){
    //DELETE USER
    $(document).on('click', '.brisanjeKorisnika', function(e){
        e.preventDefault();
        let idKorisnik = $(this).data('id');
        
        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idKorBris: idKorisnik
            },
            success: function(result){
                $('#adminKorisnici').html(result);
                $('#formaZaEditKor').html("");
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    //EDIT USER
    $(document).on('click', '.editovanjeKorisnika', function(e){
        e.preventDefault();
        let idKorisnik = $(this).data('id');
        
        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idKorEdit: idKorisnik
            },
            success: function(result){
               $('#formaZaEditKor').html(result);
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    $(document).on('click', '#editKorDugme', function(){
        var regUserEdit = $("#regUserEdit").val();
        var regMailEdit = $("#regMailEdit").val();
        var regPassEdit = $("#regPassEdit").val();
        var regIdEdit = $("#regIdEdit").val();
        var roleEdit = $("#roleEdit option:checked").val();

        var proveraUser = /^\S{3,32}$/;
        var proverMail = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
        var proveraPass = /^\S{8,32}$/;
        var greska = false;
        var notifikacija = "Greske:";

        if(!proveraUser.test(regUserEdit)){
            greska = true;
            notifikacija += "\nLos format za korisnicko ime!";
        }
        if(!proverMail.test(regMailEdit)){
            greska = true;
            notifikacija += "\nLos format za email!";
        }
        if(!proveraPass.test(regPassEdit)){
            greska = true;
            notifikacija += "\nLos format za sifru!";
        }

        if(!greska){
            $.ajax({
                url: "obrada/obradaAdmin.php",
                method: "POST",
                datatype: "JSON",
                data: {
                    poslatoEditKor: true,
                    poslatoUserEditKor: regUserEdit,
                    poslatoMailEditKor: regMailEdit,
                    poslatoPassEditKor: regPassEdit,
                    poslatoIdEditKor: regIdEdit,
                    poslatoRoleEdit: roleEdit
                },
                success: function(result){
                    $("#adminKorisnici").html(result);
                    $("#formaZaEditKor").html("<p>Uspeno izmenjen Korisnik</p>");
                },
                error: function(xhr){
                    console.log('Error');
                }
            });
        } else {
            alert(notifikacija);
        }
    });

    //INSERT USER
    $(document).on('click', '#unosKorisnikNov', function(){
        let userUnos = $('#unosKorisnikUser').val();
        let passUnos = $('#unosKorisnikPass').val();
        let mailUnos = $('#unosKorisnikMail').val();
        let roleUnos = $('#unosKorisnikRole :checked').val();
        
        var proveraUser = /^\S{3,32}$/;
        var proverMail = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
        var proveraPass = /^\S{8,32}$/;
        var greska = false;
        var notifikacija = "Greske:";

        if(!proveraUser.test(userUnos)){
            greska = true;
            notifikacija += "\nLos format za korisnicko ime!";
        }
        if(!proverMail.test(mailUnos)){
            greska = true;
            notifikacija += "\nLos format za email!";
        }
        if(!proveraPass.test(passUnos)){
            greska = true;
            notifikacija += "\nLos format za sifru!";
        }

        if(!greska){
            $.ajax({
                url: "obrada/obradaAdmin.php",
                method: "POST",
                datatype: "JSON",
                data: {
                    poslatoUnosKorisnik: true,
                    poslatoUnosUser: userUnos,
                    poslatoUnosPass: passUnos,
                    poslatoUnosMail: mailUnos,
                    poslatoUnosRole: roleUnos
                },
                success: function(result){
                    $('#adminKorisnici').html(result[0].ispis);
                    alert(result.poruka);
                },
                error: function(xhr){
                    alert(xhr.responseJSON.poruka);
                }
            });
        }else{
            alert(notifikacija);
        }
    });
       
    //DELETE USER
    $(document).on('click', '.obrisiKontakt', function(e){
        e.preventDefault();
        let idKontakt = $(this).data('id');

        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idKontDel: idKontakt
            },
            success: function(result){
                $('#adminKontakt').html(result);
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    //DELETE LEADERBOARDS
    $(document).on('click', '.obrisiLead', function(e){
        e.preventDefault();
        let idLead = $(this).data('id');

        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idLeadDel: idLead
            },
            success: function(result){
                $('#adminLead').html(result);
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    //APPROVE SUBMISSION
    $(document).on('click', '.approvePrijava', function(e){
        e.preventDefault();
        let idPrijava = $(this).data('id');
        let idKor = $(this).data('idkor');
        let vreme = $(this).data('vreme');
        let link = $(this).data('link');
        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idApprove: idPrijava,
                idKor: idKor,
                vreme: vreme,
                link: link
            },
            success: function(result){
                $('#adminPrijave').html(result[1]);
                $('#adminLead').html(result[0]);
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    //DENY SUBMISSION
    $(document).on('click', '.denyPrijava', function(e){
        e.preventDefault();
        let idKorisnik = $(this).data('id');
        
        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idDeny: idKorisnik
            },
            success: function(result){
                $('#adminPrijave').html(result);
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    //ACTIVATE SURVEY
    $(document).on('click', '.aktiviraj', function(e){
        e.preventDefault();
        let idAnkete = $(this).data('id');
        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idAktiviraj: idAnkete
            },
            success: function(result){
                $('#anketaAdmin').html(result);
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    //DEACTIVATE SURVEY
    $(document).on('click', '.deaktiviraj', function(e){
        e.preventDefault();
        let idAnkete = $(this).data('id');
        
        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idDeaktiviraj: idAnkete
            },
            success: function(result){
                $('#anketaAdmin').html(result);
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    //DELETE RUNNER
    $(document).on('click', '.brisanjeTrkaca', function(e){
        e.preventDefault();
        let idTrkac = $(this).data('id');
        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idTrkacBris: idTrkac
            },
            success: function(result){
                $('#adminTrkaci').html(result);
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    //EDIT RUNNER
    $(document).on('click', '.editovanjeTrkaca', function(e){
        e.preventDefault();
        let idTrkac = $(this).data('id');
        $.ajax({
            url: "obrada/obradaAdmin.php",
            method: "POST",
            datatype: "JSON",
            data: {
                idTrkacEdit: idTrkac
            },
            success: function(result){
               $('#izmenaTrkac').html(result);
            },
            error: function(xhr){
                console.log('Error');
            }
        });
    });

    $(document).on('click', '#editTrkacDugme', function(){
        var editTrkacId = $("#editTrkacId").val();
        var editTrkacIme = $("#editTrkacIme").val();
        var editTrkacAlt = $("#editTrkacAlt").val();
        var editTrkacOpis = $("#editTrkacOpis").val();
        var editTrkacLink1 = $("#editTrkacLink1").val();
        
        var proveraLink = /^https:\/\/www.youtube.com\/\S{5,30}$/;
        var greska = false;
        var notifikacija = "Greske:";
        
        if(editTrkacIme=="" || editTrkacAlt=="" || editTrkacOpis==""){
            greska = true;
            notifikacija += "\nNiste popunili sva polja!";
        }
        if(!proveraLink.test(editTrkacLink1)){
            greska = true;
            notifikacija += "\nLos format linka!"
        }
        
        if(!greska){
            $.ajax({
                url: "obrada/obradaAdmin.php",
                method: "POST",
                datatype: "JSON",
                data: {
                    poslatoEditTrkac: true,
                    poslatoEditId: editTrkacId,
                    poslatoEditIme: editTrkacIme,
                    poslatoEditAlt: editTrkacAlt,
                    poslatoEditOpis: editTrkacOpis,
                    poslatoEditLink1: editTrkacLink1
                },
                success: function(result){
                    $("#adminTrkaci").html(result);
                    $("#izmenaTrkac").html("<p>Uspeno izmenjen Trkac</p>");
                    
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