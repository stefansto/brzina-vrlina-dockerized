<?php
    @session_start();
    include("../konekcija.php");
    include("./funkcije.php");
    header("Content-type: application/json");

    if(isset($_POST['poslato'])){
        $obradaNaslov = $_POST['poslatoNaslov'];
        $obradaMail = $_POST['poslatoMail'];
        $obradaText = $_POST['poslatoText'];

        $greska = false;
        $statusKod = "";
        $odgovor = "";
        $tekstGreska = "Greske:";

        if($obradaNaslov==""){
            $greska = true;
            $tekstGreska .= "\nUnesite naslov!";
        }
        if($obradaText==""){
            $greska = true;
            $tekstGreska .= "\nUnesite text!";
        }
        if(!filter_var($obradaMail, FILTER_VALIDATE_EMAIL)){
            $greska = true;
            $tekstGreska .= "\nLos format e-mail adrese!";
        }

        if($greska){
            $odgovor = ["poruka" => $tekstGreska];
            $statusKod = 422;
        } else {
            echo "$greska";
            $upis = upisUTabeluKontakt($obradaNaslov, $obradaMail, $obradaText);
            if($upis){
                $odgovor = ["poruka" => "Poslato!"];
                $statusKod = 201;
            } else {
                $odgovor = ["poruka" => "Greska pri upisu!"];
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