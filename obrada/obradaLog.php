<?php
    @session_start();
    include("../konekcija.php");
    include("./funkcije.php");
    header("Content-type: application/json");

    if(isset($_POST['poslato'])){
        $obradaUser = $_POST['poslatoUser'];
        $obradaPass = $_POST['poslatoPass'];

        $greska = false;
        $statusKod = "";
        $odgovor = "";

        $proveraUser = '/^\S{3,32}$/';
        $proveraPass = '/^\S{8,32}$/';
        
        if(!preg_match($proveraUser, $obradaUser)){
            $greska = true;
        }
        if(!preg_match($proveraPass, $obradaPass)){
            $greska = true;
        }

        if($greska){
            $odgovor = ["poruka" => "Greska u unosu"];
            $statusKod = 422;
        } else {
            $upit = "korisnici WHERE userKorisnik = '$obradaUser' AND passKorisnik = '$obradaPass'";
            $tabela = vratiSve($upit);
            if($tabela){
                foreach($tabela as $red){
                    $idKorisnik = $red->idKorisnik;
                    $roleKorisnik = $red->roleKorisnik;
                    $odgovor = ["poruka" => "Good"];
                    $_SESSION['roleK'] = $roleKorisnik;
                    $_SESSION['idK'] = $idKorisnik;
                }
            }else{
                $odgovor = ["poruka" => "Pogresna sifra!"];
            }
        }
        
        http_response_code(200);
        echo json_encode($odgovor);
    } else {
        http_response_code(404);
        header("Location: ../index.php");
    }
?>