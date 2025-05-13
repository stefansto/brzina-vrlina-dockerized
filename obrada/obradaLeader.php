<?php
    @session_start();
    include("../konekcija.php");
    include("./funkcije.php");
    header("Content-type: application/json");

    if(isset($_POST['poslato'])){
        $obradaText = $_POST['poslatoText'];
        $greska = true;
        $statusKod = "";
        $odgovor = "";

        if($obradaText==""){
            $greska = true;
        }
        
        $tabelaLead = vratiSve("leaderboards l JOIN korisnici k ON l.idRunner = k.idKorisnik");
        $nizUser = [];
        $nizVreme = [];
        foreach($tabelaLead as $red){
            $nizUser[] = $red->userKorisnik;
            $nizVreme[] = $red->vremeLead;
        }
        
        if(in_array($obradaText, $nizUser)){
            $greska = false;
        }
        if(in_array($obradaText, $nizVreme)){
            $greska = false;
        }
        
        if($greska){
            $odgovor = ["poruka" => "Ne postoji"];
            $statusKod = 422;
        } else {
            $upit = "SELECT * FROM leaderboards l JOIN korisnici k ON l.idRunner = k.idKorisnik WHERE userKorisnik LIKE :text1 OR vremeLead = :text2 ORDER BY vremeLead";
            $ps = $konekcija->prepare($upit);
            $ps->bindParam(":text1", $obradaText);
            $ps->bindParam(":text2", $obradaText);
            $ps->execute();
            $rez = $ps->fetchAll();

            if($rez){
                $zaOdgovor = "";
                foreach($rez as $red){
                    $runnerLead = $red->userKorisnik;
                    $vremeLead = $red->vremeLead;
                    $linkLead = $red->linkLead;
                    $zaOdgovor .= "<tr><td>#</td><td>$runnerLead</td><td>$vremeLead</td><td><a class=\"btn btn-light\" href=\"$linkLead\">Video</a></td></tr>";
                }
                $odgovor = $zaOdgovor;
                $statusKod = 200;
            } else {
                $odgovor = ["poruka" => "Greska pri upisu u bazu"];
                $statusKod = 500;
            }
        }
        
        http_response_code($statusKod);
        echo json_encode($odgovor);
    }else if (isset($_POST['poslatoReset'])){
        $tabela = vratiSve("leaderboards l JOIN korisnici k ON l.idRunner = k.idKorisnik ORDER BY vremeLead");
        $mestoLead = 0;
        if($tabela){
            $ispisLead = "";
            foreach($tabela as $red){
                $mestoLead++;
                $runnerLead = $red->userKorisnik;
                $vremeLead = $red->vremeLead;
                $linkLead = $red->linkLead;
                $ispisLead .= "<tr><td>$mestoLead</td><td>$runnerLead</td><td>$vremeLead</td><td><a class=\"btn btn-light\" href=\"$linkLead\">Video</a></td></tr>";
            }
            echo json_encode($ispisLead);
        }
    } else {
        http_response_code(404);
        header("Location: ../index.php");
    }
?>