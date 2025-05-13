<?php
    @session_start();
    include("../konekcija.php");
    include("./funkcije.php");
    header("Content-type: application/json");

    if($_SERVER['REQUEST_METHOD']!="POST"){
        http_response_code(404);
        header("Location: ../index.php");
    }

    //DELETE USER
    if (isset($_POST['idKorBris'])){
        $idKorBris = $_POST['idKorBris'];
        $brisanje = obrisi("korisnici", "idKorisnik", $idKorBris);
        if($brisanje){
            $tabela = vratiSve("korisnici k JOIN roles r ON k.roleKorisnik = r.idRole");
            $ispisKorisnici = "";
            if($tabela){
                foreach($tabela as $red){
                    $idKorisnik = $red->idKorisnik;
                    $userKorisnik = $red->userKorisnik;
                    $mailKorisnik = $red->mailKorisnik;
                    $passKorisnik = $red->passKorisnik;
                    $roleKorisnik = $red->nazivRole;
                    $datumRegKorisnik = $red->datumRegKorisnik;
                    $datumRegKorisnik = date('d. m. Y.', strtotime($datumRegKorisnik));
                    $ispisKorisnici .= "<tr><td>$idKorisnik</td><td>$userKorisnik</td><td>$mailKorisnik</td><td>$passKorisnik</td><td>$roleKorisnik</td><td>$datumRegKorisnik</td>
                    <td><a href='#' data-id='$idKorisnik' class='brisanjeKorisnika btn btn-danger'>Obrisi</a></td>
                    <td><a href='#' data-id='$idKorisnik' class='editovanjeKorisnika btn btn-primary'>Izmeni</a></td></tr>";
                }
            }
            http_response_code(200);
            echo json_encode($ispisKorisnici);
            
        }
    }

    //EDIT USER
    if (isset($_POST['idKorEdit'])){
        $idKorEdit = $_POST['idKorEdit'];
        $ispisForme = "";
        $upit = "SELECT * FROM korisnici WHERE idKorisnik = $idKorEdit";
        $ps = $konekcija->query($upit)->fetchAll();
        if($ps){
            $userKorisnikEdit = $ps[0]->userKorisnik;
            $passKorisnikEdit = $ps[0]->passKorisnik;
            $mailKorisnikEdit = $ps[0]->mailKorisnik;
            $roleKorisnikEdit = $ps[0]->roleKorisnik;

            $ispisForme = "
                <form>
                <h1 class=\"h3 mb-3 fw-normal\">ID: $idKorEdit</h1>
                <input type=\"hidden\" id=\"regIdEdit\" value='$idKorEdit'>
                <p>Korisnicko ime</p>
                <input type=\"text\" id=\"regUserEdit\" class=\"form-control\" placeholder=\"Username\" value='$userKorisnikEdit' required autofocus>
                <p>Sifra</p>
                <input type=\"password\" id=\"regPassEdit\" class=\"form-control\" placeholder=\"Mail\" value='$passKorisnikEdit' required>
                <p>E-Mail</p>
                <input type=\"email\" id=\"regMailEdit\" class=\"form-control\" placeholder=\"Password\" value='$mailKorisnikEdit' required>
                <p>Uloga</p>
                <select class=\"form-control\" id=\"roleEdit\">";
                
                if($roleKorisnikEdit==1){
                    $ispisForme .= "
                        <option value=\"1\" selected>Admin</option>
                        <option value=\"2\">Korisnik</option>";
                }else if($roleKorisnikEdit==2){
                    $ispisForme .= "
                        <option value=\"1\">Admin</option>
                        <option value=\"2\" selected>Korisnik</option>";
                }
            $ispisForme .= "</select>
                <input type=\"button\" id=\"editKorDugme\" class=\"w-100 btn btn-lg btn-primary\" value=\"Izmeni\"/>
                </form>";
        }
        http_response_code(200);
        echo json_encode($ispisForme);
    }

    if (isset($_POST['poslatoEditKor'])){
        $poslatoUserEditKor = $_POST['poslatoUserEditKor'];
        $poslatoMailEditKor = $_POST['poslatoMailEditKor'];
        $poslatoPassEditKor = $_POST['poslatoPassEditKor'];
        $poslatoIdEditKor = $_POST['poslatoIdEditKor'];
        $poslatoRoleEditKor = $_POST['poslatoRoleEdit'];

        $upit = "UPDATE `korisnici` SET `userKorisnik`= :userEdit, `mailKorisnik`= :mailEdit, `passKorisnik`= :passEdit,`roleKorisnik`= :roleEdit WHERE `idKorisnik`= :idEdit";
        $ps = $konekcija->prepare($upit);
        $ps->bindParam(":userEdit",$poslatoUserEditKor);
        $ps->bindParam(":mailEdit",$poslatoMailEditKor);
        $ps->bindParam(":passEdit",$poslatoPassEditKor);
        $ps->bindParam(":roleEdit",$poslatoRoleEditKor);
        $ps->bindParam(":idEdit",$poslatoIdEditKor);
        $ps->execute();
        if($ps){
            $tabela = vratiSve("korisnici k JOIN roles r ON k.roleKorisnik = r.idRole");
            if($tabela){
                $ispisKorisnici = "";
                foreach($tabela as $red){
                    $idKorisnik = $red->idKorisnik;
                    $userKorisnik = $red->userKorisnik;
                    $mailKorisnik = $red->mailKorisnik;
                    $passKorisnik = $red->passKorisnik;
                    $roleKorisnik = $red->nazivRole;
                    $datumRegKorisnik = $red->datumRegKorisnik;
                    $datumRegKorisnik = date('d. m. Y.', strtotime($datumRegKorisnik));
                    $ispisKorisnici .= "<tr><td>$idKorisnik</td><td>$userKorisnik</td><td>$mailKorisnik</td><td>$passKorisnik</td><td>$roleKorisnik</td><td>$datumRegKorisnik</td>
                    <td><a href='#' data-id='$idKorisnik' class='brisanjeKorisnika btn btn-danger'>Obrisi</a></td>
                    <td><a href='#' data-id='$idKorisnik' class='editovanjeKorisnika btn btn-primary'>Izmeni</a></td></tr>";
                }
                http_response_code(200);
                echo json_encode($ispisKorisnici);
                
            }
        }
    }

    //INSERT USER
    if(isset($_POST['poslatoUnosKorisnik'])){
        $poslatoUnosUser = $_POST['poslatoUnosUser'];
        $poslatoUnosPass = $_POST['poslatoUnosPass'];
        $poslatoUnosMail = $_POST['poslatoUnosMail'];
        $poslatoUnosRole = $_POST['poslatoUnosRole'];
        
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
        if(in_array($poslatoUnosUser, $nizUserKorisnik)){
            $greska = true;
            $tekstGreska .= "\nZauzeto korisnicko ime!";
        }
        if(in_array($poslatoUnosMail, $nizMailKorisnik)){
            $greska = true;
            $tekstGreska .= "\nVec iskoriscen e-mail!";
        }
        if(!preg_match($proveraUser, $poslatoUnosUser)){
            $greska = true;
            $tekstGreska .= "\nLos format korisnickog imena!";
        }
        if(!preg_match($proveraPass, $poslatoUnosPass)){
                $greska = true;
                $tekstGreska .= "\nLos format sifre!";
        }
        if(!filter_var($poslatoUnosMail, FILTER_VALIDATE_EMAIL)){
            $greska = true;
            $tekstGreska .= "\nLos format e-mail adrese!";
        }

        if($greska){
            $statusKod = 422;
            $odgovor = ["poruka" => $tekstGreska];
        }
        else{
            echo "$greska";

            $upit = "INSERT INTO korisnici(`userKorisnik`, `mailKorisnik`, `passKorisnik`, `roleKorisnik`) VALUES(:user, :mail, :pass, :rol)";
            $ps = $konekcija->prepare($upit);
            $ps->bindParam(":user", $poslatoUnosUser);
            $ps->bindParam(":mail", $poslatoUnosMail);
            $ps->bindParam(":pass", $poslatoUnosPass);
            $ps->bindParam(":rol", $poslatoUnosRole);
            $rez = $ps->execute();
            

            if($rez){
                $odgovor = ["poruka" => "Upisani"];
                $statusKod = 201;
            }else{
                $odgovor = ["poruka" => "Greska pri upisu u bazu"];
                $statusKod = 500;
            }

            $tabela = vratiSve("korisnici k JOIN roles r ON k.roleKorisnik = r.idRole");
            if($tabela){
                $ispisKorisnici = "";
                foreach($tabela as $red){
                    $idKorisnik = $red->idKorisnik;
                    $userKorisnik = $red->userKorisnik;
                    $mailKorisnik = $red->mailKorisnik;
                    $passKorisnik = $red->passKorisnik;
                    $roleKorisnik = $red->nazivRole;
                    $datumRegKorisnik = $red->datumRegKorisnik;
                    $datumRegKorisnik = date('d. m. Y.', strtotime($datumRegKorisnik));
                    $ispisKorisnici .= "<tr><td>$idKorisnik</td><td>$userKorisnik</td><td>$mailKorisnik</td><td>$passKorisnik</td><td>$roleKorisnik</td><td>$datumRegKorisnik</td>
                    <td><a href='#' data-id='$idKorisnik' class='brisanjeKorisnika btn btn-danger'>Obrisi</a></td>
                    <td><a href='#' data-id='$idKorisnik' class='editovanjeKorisnika btn btn-primary'>Izmeni</a></td></tr>";
                }
                $odgovor[] = ["ispis" => $ispisKorisnici];
            }
        }
        http_response_code($statusKod);
        echo json_encode($odgovor);
    }

    //DELETE CONTANT
    if (isset($_POST['idKontDel'])){
        $idKontDel = $_POST['idKontDel'];
        $brisanje = obrisi("kontakt", "idKontakt", $idKontDel);

        if($brisanje){
            $tabela = vratiSve("kontakt");
            $ispisKontakt = "";
            if($tabela){
                foreach($tabela as $red){
                    $idKontakt = $red->idKontakt;
                    $naslovKontakt = $red->naslovKontakt;
                    $mailKontakt = $red->mailKontakt;
                    $datumKontakt = $red->datumKontakt;
                    $textKontakt = $red->textKontakt;
                    $ispisKontakt .= "<tr><td>$idKontakt</td><td>$naslovKontakt</td><td>$mailKontakt</td><td>$datumKontakt</td><td>$textKontakt</td>";
                    $ispisKontakt .= "<td><a href='#' data-id='$idKontakt' class='obrisiKontakt btn btn-danger'>Obrisi</a></td></tr>";
                }
            }
            http_response_code(200);
            echo json_encode($ispisKontakt);
            
        }
    }

    //DELETE LEADERBOARD
    if (isset($_POST['idLeadDel'])){
        $idLeadDel = $_POST['idLeadDel'];
        $brisanje = obrisi("leaderboards", "idLead", $idLeadDel);

        if($brisanje){
            $tabela = vratiSve("leaderboards l JOIN korisnici k ON l.idRunner = k.idKorisnik ORDER BY vremeLead");
            $mestoLead = 0;
            $ispisLead = "";
            if($tabela){
                foreach($tabela as $red){
                    $mestoLead++;
                    $idLead = $red->idLead;
                    $runnerLead = $red->userKorisnik;
                    $vremeLead = $red->vremeLead;
                    $linkLead = $red->linkLead;
                    $ispisLead .= "<tr><td>$mestoLead</td><td>$runnerLead</td><td>$vremeLead</td><td><a class=\"btn btn-light\" href=\"$linkLead\">Video</a></td>";
                    $ispisLead.= "<td><a href='#' data-id='$idLead' class='obrisiLead btn btn-danger'>Obrisi</a></td></tr>";
                }
            }
            http_response_code(200);
            echo json_encode($ispisLead);
            
        }
    }
    
    //UPDATE SUBMISSION APPROVE AND INSERT LEADERBOARD
    if (isset($_POST['idApprove'])){
        $idApprove = $_POST['idApprove'];
        $idKor = $_POST['idKor'];
        $vreme = $_POST['vreme'];
        $link = $_POST['link'];
        $approve = prijava("prijave", "odobreno", 1, "idPrijava", $idApprove);
        $insertULead = "INSERT INTO `leaderboards` (`idRunner`, `vremeLead`, `linkLead`) VALUES (:idKor, :vreme, :link)";
        
        $ps = $konekcija->prepare($insertULead);
        $ps->bindParam(":idKor", $idKor);
        $ps->bindParam(":vreme", $vreme);
        $ps->bindParam(":link", $link);
        $rez = $ps->execute();

        if($rez){
            $tabela = vratiSve("leaderboards l JOIN korisnici k ON l.idRunner = k.idKorisnik ORDER BY vremeLead");
            $mestoLead = 0;
            if($tabela){
                $ispisLead = "";
                foreach($tabela as $red){
                    $mestoLead++;
                    $idLead = $red->idLead;
                    $runnerLead = $red->userKorisnik;
                    $vremeLead = $red->vremeLead;
                    $linkLead = $red->linkLead;
                    $ispisLead .= "<tr><td>$mestoLead</td><td>$runnerLead</td><td>$vremeLead</td><td><a class=\"btn btn-light\" href=\"$linkLead\">Video</a></td>";
                    $ispisLead.= "<td><a href='#' data-id='$idLead' class='obrisiLead btn btn-danger'>Obrisi</a></td></tr>";
                }
            }
        }

        if($approve){
            $tabela = vratiSve("prijave p JOIN korisnici k ON p.idKorisnik = k.idKorisnik ORDER BY idPrijava");
            if($tabela){
                $ispisPrijava = "";
                foreach($tabela as $red){
                    $idPrijava = $red->idPrijava;
                    $idKorisnik = $red->userKorisnik;
                    $vreme = $red->vreme;
                    $link = $red->link;
                    $komentar = $red->komentar;
                    $odobreno = $red->odobreno;

                    $idKor = $red->idKorisnik;
                    $ispisPrijava .= "<tr><td>$idPrijava</td><td>$idKorisnik</td><td>$vreme</td><td><a class=\"btn btn-light\" href=\"$link\">Video</a></td><td>$komentar</td><td>";
                    if($odobreno==null){
                      $ispisPrijava .= "<a href='#' data-id='$idPrijava' data-idkor='$idKor' data-vreme='$vreme' data-link='$link' class='approvePrijava btn btn-success'>Prihvati</a>
                                        <a href='#' data-id='$idPrijava' class='denyPrijava btn btn-danger'>Odbij</a></td></tr>";
                    }else if($odobreno==1){
                        $ispisPrijava .= "Prihvaceno</td></tr>";
                    }else{
                        $ispisPrijava .= "Odbijeno</td></tr>";
                    }
                }
                $odgovor[] = $ispisLead;
                $odgovor[] = $ispisPrijava;
                http_response_code(200);
                echo json_encode($odgovor);
                
            }
        }
    }

    //UPDATE SUBMISSION DENY AND INSERT LEADERBOARD
    if (isset($_POST['idDeny'])){
        $idDeny = $_POST['idDeny'];
        $deny = prijava("prijave", "odobreno", 2, "idPrijava", $idDeny);

        if($deny){
            $tabela = vratiSve("prijave p JOIN korisnici k ON p.idKorisnik = k.idKorisnik ORDER BY idPrijava");
            if($tabela){
                $ispisPrijava = "";
                foreach($tabela as $red){
                    $idPrijava = $red->idPrijava;
                    $idKorisnik = $red->userKorisnik;
                    $vreme = $red->vreme;
                    $link = $red->link;
                    $komentar = $red->komentar;
                    $odobreno = $red->odobreno;

                    $idKor = $red->idKorisnik;
                    $ispisPrijava .= "<tr><td>$idPrijava</td><td>$idKorisnik</td><td>$vreme</td><td><a class=\"btn btn-light\" href=\"$link\">Video</a></td><td>$komentar</td><td>";
                    if($odobreno==null){
                        $ispisPrijava .= "<a href='#' data-id='$idPrijava' data-idkor='$idKor' data-vreme='$vreme' data-link='$link' class='approvePrijava btn btn-success'>Prihvati</a>
                                        <a href='#' data-id='$idPrijava' class='denyPrijava btn btn-danger'>Odbij</a></td></tr>";
                    }else if($odobreno==1){
                        $ispisPrijava .= "Prihvaceno</td></tr>";
                    }else {
                        $ispisPrijava .= "Odbijeno</td></tr>";
                    }
                }
                http_response_code(200);
                echo json_encode($ispisPrijava);
            }
        }
    }

    //UPDATE SURVER ACTIVE
    if (isset($_POST['idAktiviraj'])){
        $idAktiviraj = $_POST['idAktiviraj'];
        $upitAktiv = "UPDATE ankete SET aktivnaAnketa = 1 WHERE idAnketa = :idAktiviraj";
        $ps = $konekcija->prepare($upitAktiv);
        $ps->bindParam(":idAktiviraj", $idAktiviraj);
        $ps->execute();

        if($ps){
            $tabela = vratiSve("ankete");
            $ispisAnkete = "<table class=\"table table-dark table-striped table-sm\"><thead><tr><th>ID Ankete</th><th>Pitanje</th><th>Izmeni</th></tr></thead>";
            if($tabela){
                foreach($tabela as $red){
                    $ispisAnkete.= "<tr><td>$red->idAnketa</td><td>$red->pitanjeAnketa</td><td>";
                    if($red->aktivnaAnketa){
                        $ispisAnkete.= "<a href='#' data-id='$red->idAnketa' class='deaktiviraj btn btn-danger'>Deaktiviraj</a>";
                    }else{
                        $ispisAnkete.= "<a href='#' data-id='$red->idAnketa' class='aktiviraj btn btn-success'>Aktiviraj</a>";
                    }
                    $ispisAnkete.= "</td></tr>";
                }
                $ispisAnkete.= "</table>";
            }
            http_response_code(200);
            echo json_encode($ispisAnkete);
        }
    }

    //UPDATE SURVER ACTIVE
    if (isset($_POST['idDeaktiviraj'])){
        $idDeaktiviraj = $_POST['idDeaktiviraj'];
        $upitDeaktiv = "UPDATE ankete SET aktivnaAnketa = 0 WHERE idAnketa = :idDeaktiviraj";
        $ps = $konekcija->prepare($upitDeaktiv);
        $ps->bindParam(":idDeaktiviraj", $idDeaktiviraj);
        
        $ps->execute();
        if($ps){
            $tabela = vratiSve("ankete");
            $ispisAnkete = "<table class=\"table table-dark table-striped table-sm\"><thead><tr><th>ID Ankete</th><th>Pitanje</th><th>Izmeni</th></tr></thead>";
            if($tabela){
                foreach($tabela as $red){
                    $ispisAnkete.= "<tr><td>$red->idAnketa</td><td>$red->pitanjeAnketa</td><td>";
                    if($red->aktivnaAnketa){
                        $ispisAnkete.= "<a href='#' data-id='$red->idAnketa' class='deaktiviraj btn btn-danger'>Deaktiviraj</a>";
                    }else{
                        $ispisAnkete.= "<a href='#' data-id='$red->idAnketa' class='aktiviraj btn btn-success'>Aktiviraj</a>";
                    }
                    $ispisAnkete.= "</td></tr>";
                }
                $ispisAnkete.= "</table>";
            }
            http_response_code(200);
            echo json_encode($ispisAnkete);
        }
    }

    //DELETE RUNNER
    if (isset($_POST['idTrkacBris'])){
        $idTrkacBris = $_POST['idTrkacBris'];
        $brisanje = obrisi("trkaci", "idTrkac", $idTrkacBris);

        if($brisanje){
            $tabela = vratiSve("trkaci");
            $ispisTrkaci = "";
            if($tabela){
                foreach($tabela as $red){
                    $idTrkac = $red->idTrkac;
                    $imeTrkac = $red->imeTrkac;
                    $slikaTrkac = $red->slikaTrkac;
                    $opisTrkac = $red->opisTrkac;
                    $link1Trkac = $red->link1Trkac;
                    $altTrkac = $red->altSlikaTrkac;
                    $ispisTrkaci .= "<tr><td>$idTrkac</td><td>$imeTrkac</td><td><img src=$slikaTrkac alt=$altTrkac></td><td>$opisTrkac</td><td>$link1Trkac</td>
                    <td><a href='#' data-id='$idTrkac' class='brisanjeTrkaca btn btn-danger'>Obrisi</a></td>
                    <td><a href='#' data-id='$idTrkac' class='editovanjeTrkaca btn btn-primary'>Izmeni</a></td></tr>";
                }
            }
            http_response_code(200);
            echo json_encode($ispisTrkaci);
        }
    }

    //UPDATE RUNNER
    if(isset($_POST['idTrkacEdit'])){
        $idTrkacEdit = $_POST['idTrkacEdit'];
        $ispisFormeEditTrkac = "";

        $upit = "SELECT * FROM trkaci WHERE idTrkac = $idTrkacEdit";
        
        $ps = $konekcija->query($upit)->fetchAll();
        if($ps){
            $imeTrkacEdit = $ps[0]->imeTrkac;
            $altSlikaTrkacEdit = $ps[0]->altSlikaTrkac;
            $opisTrkacEdit = $ps[0]->opisTrkac;
            $link1TrkacEdit = $ps[0]->link1Trkac;

            $ispisFormeEditTrkac = "
                <form>
                    <h1 class=\"h3 mb-3 fw-normal\">ID: $idTrkacEdit</h1>
                    <input type=\"hidden\" id=\"editTrkacId\" value='$idTrkacEdit'>
                    <p>Ime Trkaca:</p>
                    <input type=\"text\" id=\"editTrkacIme\" class=\"form-control\" placeholder=\"Ime\" value='$imeTrkacEdit' required>
                    <p>Alt Slike:</p>
                    <input type=\"text\" id=\"editTrkacAlt\" class=\"form-control\" placeholder=\"Alt\" value='$altSlikaTrkacEdit' required>
                    <p>Opis Trkaca:</p>
                    <textarea colls=\"10\" id=\"editTrkacOpis\" rows=\"4\" class=\"form-control\" placeholder=\"Opis\" required>$opisTrkacEdit</textarea>
                    <p>Link Trkaca:</p>
                    <input type=\"text\" id=\"editTrkacLink1\" class=\"form-control\" placeholder=\"Youtube Link\" value='$link1TrkacEdit' required>

                    <input type=\"button\" id=\"editTrkacDugme\" class=\"w-100 btn btn-lg btn-primary\" value=\"Izmeni\"/>
                </form>";
        }
        http_response_code(200);
        echo json_encode($ispisFormeEditTrkac);
    }

    if (isset($_POST['poslatoEditTrkac'])){
        $poslatoEditId = $_POST['poslatoEditId'];
        $poslatoEditIme = $_POST['poslatoEditIme'];
        $poslatoEditAlt = $_POST['poslatoEditAlt'];
        $poslatoEditOpis = $_POST['poslatoEditOpis'];
        $poslatoEditLink = $_POST['poslatoEditLink1'];
        $greska = false;
        $proveraLink = '/^https:\/\/www.youtube.com\/\S{5,30}$/';

        if(!preg_match($proveraLink, $poslatoEditLink)){
            $greska = true;
            $odgovor = ["poruka" => "Los Format Linka!"];
        }
        if($poslatoEditIme=="" || $poslatoEditAlt=="" || $poslatoEditOpis==""){
            $greska = true;
            $odgovor = ["poruka" => "Niste popunili sva polja!"];
        }

        if(!$greska){
            $upit = "UPDATE trkaci SET imeTrkac=:ime, altSlikaTrkac=:alt,opisTrkac=:opis,link1Trkac=:link WHERE idTrkac=:id";
            $ps = $konekcija->prepare($upit);
            $ps->bindParam(":ime",$poslatoEditIme);
            $ps->bindParam(":alt",$poslatoEditAlt);
            $ps->bindParam(":opis",$poslatoEditOpis);
            $ps->bindParam(":link",$poslatoEditLink);
            $ps->bindParam(":id",$poslatoEditId);
            $ps->execute();
            if($ps){
                $tabela = vratiSve("trkaci");
                if($tabela){
                    $ispisTrkaci = "";
                    foreach($tabela as $red){
                        $idTrkac = $red->idTrkac;
                        $imeTrkac = $red->imeTrkac;
                        $slikaTrkac = $red->slikaTrkac;
                        $opisTrkac = $red->opisTrkac;
                        $link1Trkac = $red->link1Trkac;
                        $altTrkac = $red->altSlikaTrkac;
                        $ispisTrkaci .= "<tr><td>$idTrkac</td><td>$imeTrkac</td><td><img src=$slikaTrkac alt=$altTrkac></td><td>$opisTrkac</td><td>$link1Trkac</td>
                        <td><a href='#' data-id='$idTrkac' class='brisanjeTrkaca btn btn-danger'>Obrisi</a></td>
                        <td><a href='#' data-id='$idTrkac' class='editovanjeTrkaca btn btn-primary'>Izmeni</a></td></tr>";
                    }
                    http_response_code(200);
                    echo json_encode($ispisTrkaci);
                }
            }
        }else{
            http_response_code(422);
            echo json_encode($odgovor);
        }
    }
?>



                        