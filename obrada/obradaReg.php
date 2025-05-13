<?php
    @session_start();
    include("../konekcija.php");
    include("../obrada/funkcije.php");
    header("Content-type: application/json");

    if(isset($_POST['poslato'])){
        $obradaUser = $_POST['poslatoUser'];
        $obradaMail = $_POST['poslatoMail'];
        $obradaPass = $_POST['poslatoPass'];
        $obradaPass2 = $_POST['poslatoPass2'];

        $greska = false;
        $statusKod = "";
        $odgovor = "";

        $proveraUser = '/^\S{3,32}$/';
        $proveraPass = '/^\S{8,32}$/';
        $tekstGreska = "Greske:";
        
        $tabelaKorisnici = vratiSve("korisnici");
        $nizUserKorisnik = [];
        $nizMailKorisnik = [];
        foreach($tabelaKorisnici as $korisnik){
            $nizUserKorisnik[] = $korisnik->userKorisnik;
            $nizMailKorisnik[] = $korisnik->mailKorisnik;
        }
        
        if(in_array($obradaUser, $nizUserKorisnik)){
            $greska = true;
            $tekstGreska .= "\nZauzeto korisnicko ime!";
        }
        if(in_array($obradaMail, $nizMailKorisnik)){
            $greska = true;
            $tekstGreska .= "\nVec iskoriscen e-mail!";
        }
        
        if(!preg_match($proveraUser, $obradaUser)){
            $greska = true;
            $tekstGreska .= "\nLos format korisnickog imena!";
        }
        if(!preg_match($proveraPass, $obradaPass)){
            if($obradaPass!=$obradaPass2){
                $greska = true;
                $tekstGreska .= "\nLos format sifre!";
            }
        }
        if(!filter_var($obradaMail, FILTER_VALIDATE_EMAIL)){
            $greska = true;
            $tekstGreska .= "\nLos format e-mail adrese!";
        }
        
        if($greska){
            $statusKod = 422;
            $odgovor = ["poruka" => $tekstGreska];
        } else {
            echo "$greska";

            $upis = upisUTabeluKorisnici($obradaUser, $obradaMail, $obradaPass);

            if($upis){
                $odgovor = ["poruka" => "Upisani"];
                $statusKod = 201;

                $upit = "SELECT idKorisnik FROM korisnici WHERE userKorisnik='$obradaUser'";
                $rez = $konekcija->query($upit)->fetchAll();
                $idKorisnika = $rez[0]->idKorisnik;
                if($idKorisnika){
                    $_SESSION['idK'] = $idKorisnika;
                    $_SESSION['roleK'] = 2;
                    $odgovor = ["poruka" => "Uspesna registracija!"];
                }
            } else {
                $odgovor = ["poruka" => "Greska pri upisu u bazu"];
                $statusKod = 500;
            }
        }

        http_response_code($statusKod);
        echo json_encode($odgovor);
    } else {
        http_response_code(404);
        header("Location: ../index.php");
    }
?>