<?php
    @session_start();
    include("../konekcija.php");
    include("./funkcije.php");
    header("Content-type: application/json");

    if(isset($_POST['poslato'])){
        $obradaId = $_POST['poslatoId'];
        $obradaVreme = $_POST['poslatoVreme'];
        $obradaLink = $_POST['poslatoLink'];
        $obradaKomentar = $_POST['poslatoKomentar'];

        $greska = false;
        $statusKod = "";
        $odgovor = "";

        $proveraVreme = '/^([0-9]{1,2}):[0-9]{1,2}(:[0-9]{1,2})$/';
        $proveraLink = '/^https:\/\/www.youtube.com\/\S{5,30}$/';

        if(!preg_match($proveraVreme, $obradaVreme)){
            $greska = true;
            $odgovor = ["poruka" => "Los Format Vremena!"];
        }
        if(!preg_match($proveraLink, $obradaLink)){
            $greska = true;
            $odgovor = ["poruka" => "Los Format Linka!"];
        }

        if($greska){
            echo "$greska";
            $odgovor = ["poruka" => "Greska u unosu"];
            $statusKod = 422;
        } else {
            echo "$greska";
            $upis = upisUTabeluPrijave($obradaId, $obradaVreme, $obradaLink, $obradaKomentar);
            if($upis){
                $odgovor = ["poruka" => "Uspesno ste prijavili vase vreme!"];
                $statusKod = 201;
            }else{
                $odgovor = ["poruka" => "Greska pri upisu"];
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