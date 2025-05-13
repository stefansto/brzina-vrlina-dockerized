<?php 
    session_start();
    include ("../konekcija.php");
    if(isset($_POST['unosTrkacDugme'])){
        $unosTrkacIme = $_POST['unosTrkacIme'];
        $unosTrkacOpis = $_POST['unosTrkacOpis'];
        $unosTrkacLink1 = $_POST['unosTrkacLink1'];
        $unosTrkacAlt = $_POST['unosTrkacAlt'];

        $slika = $_FILES['unosTrkacSlika'];
        $imeSlika = $slika['name'];
        $tmpSlika = $slika['tmp_name'];
        $velicinaSlika = $slika['size'];
        $tipSlika = $slika['type'];
        $greskeSlika = $slika['error'];
        $greska = false;
        $greskaTekst = "Greske: ";
        $statusKod = 200;
        
        $proveraLink = '/^https:\/\/www.youtube.com\/\S{5,70}$/';

        if(!preg_match($proveraLink, $unosTrkacLink1)){
            $greska = true;
            $greskaTekst .= "\nLos Format Linka!";
            $statusKod = 422;
        }
        if($unosTrkacIme=="" || $unosTrkacOpis=="" || $unosTrkacLink1=="" || $unosTrkacAlt==""){
            $greska = true;
            $greskaTekst .= "\nNiste popunili sva polja!";
            $statusKod = 422;
        }

        if(!$greskeSlika){
            $dozvoljeniTipovi = ["image/jpg" , "image/jpeg", "image/png"];
            if(!in_array($tipSlika, $dozvoljeniTipovi)){
                $greska = true;
                $greskaTekst .= "\nNedozvoljen tip!";
                $statusKod = 422;
            }

            if($velicinaSlika > 500000){
                $greska = true;
                $greskaTekst .= "\nPrevelika velicina slike!";
                $statusKod = 422;
            }

            if($greska){
                $_SESSION['uploadGreska'] = $greskaTekst;
                http_response_code($statusKod);
                header("Location: ../admin.php");
            }else{
                $slikaUpis = "slike/".time()."_".$imeSlika;
                $putanja = "../$slikaUpis";

                if(move_uploaded_file($tmpSlika, $putanja)){
                    $upit = "INSERT INTO trkaci(imeTrkac, slikaTrkac, altSlikaTrkac, velicinaSlikaTrkac, tipSlikaTrkac, opisTrkac, link1Trkac) VALUES (:ime, :slika, :alt, :velicina, :tip, :opis, :link)";
                    $upis = $konekcija->prepare($upit);
                    $upis->bindParam(":ime", $unosTrkacIme);
                    $upis->bindParam(":slika", $slikaUpis);
                    $upis->bindParam(":alt", $unosTrkacAlt);
                    $upis->bindParam(":velicina", $velicinaSlika);
                    $upis->bindParam(":tip", $tipSlika);
                    $upis->bindParam(":opis", $unosTrkacOpis);
                    $upis->bindParam(":link", $unosTrkacLink1);
                    $rez = $upis->execute();
                    if($rez){
                        header("Location: ../admin.php");
                    }else{
                        $greskaTekst = "Nije uspeo upis u bazu!";
                        $_SESSION['uploadGreska'] = $greskaTekst;
                        header("Location: ../admin.php");
                    }
                }else{
                    $greskaTekst = "Greska pri uploadu slike!";
                    $_SESSION['uploadGreska'] = $greskaTekst;
                    header("Location: ../admin.php");
                }
            }
        }else{
            $greskaTekst .= "\nNiste izabrali sliku!";
            $_SESSION['uploadGreska'] = $greskaTekst;
            header("Location: ../admin.php");
        }
    }else{
        header("Location: ../index.php");
    }
?>