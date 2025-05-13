<?php 
    @session_start();
    include("../konekcija.php");
    include("./funkcije.php");
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD']!="POST"){
        http_response_code(404);
        header("Location: ../index.php");
    }

    //VOTE
    if(isset($_POST['poslatoGlasaj'])){
        $idAnketa = $_POST['poslatoAnketa'];
        $idOdgovor = $_POST['poslatoOdgovor'];
        $idKorisnik = $_POST['poslatoKorisnik'];

        $upit = "SElECT * FROM rezultati WHERE idKorisnik = $idKorisnik AND idAnketa = $idAnketa";
        $rez = $konekcija->query($upit)->fetchAll();
        if($rez){
            $greska = "<p>Vec ste glasali!</p>";
            echo json_encode($greska);
        }else{
            $upit = "INSERT INTO `rezultati`(`idAnketa`, `idOdgovor`, `idKorisnik`) VALUES (:idAnketa, :idOdgovor, :idKorisnik)";
            $ps = $konekcija->prepare($upit);
            $ps->bindParam(":idAnketa", $idAnketa);
            $ps->bindParam(":idOdgovor", $idOdgovor);
            $ps->bindParam(":idKorisnik", $idKorisnik);
            $ps->execute();
            if($ps){
                $greska = "<p>Hvala na odgovoru!</p>";
                echo json_encode($greska);
            }
        }
    }

    //SHOW RESULTS
    if(isset($_POST['poslatoRezultat'])){
        $idAnketa = $_POST['poslatoAnketa'];
        $upit = "SELECT userKorisnik, odgovorAnketa FROM rezultati r JOIN korisnici k ON r.idKorisnik = k.idKorisnik JOIN odgovori o ON r.idOdgovor = o.idOdgovor WHERE r.idAnketa = $idAnketa";
        $rez = $konekcija->query($upit)->fetchAll();
        if($rez){
            $ispis = "<h3>Rezultati:</h3><table class='table table-dark'><thead><tr><th>Korisnik</th><th>Odgovor</th></tr></thead>";
            foreach($rez as $red){
                $ispis.= "<tr><td>$red->userKorisnik</td><td>$red->odgovorAnketa</td></tr>";
            }
            $ispis.= "</table>";
        }else{
            $ispis = "<h4>Nema odgovora!</h4>";
        }
        echo json_encode($ispis);
    }
?>