<?php
  include("konekcija.php");
  include("fixed/head.php");
  include("fixed/header.php");
  include("obrada/funkcije.php");
  if(isset($_SESSION['roleK'])){
    if($_SESSION['roleK']!=1)header("Location: index.php");
  } else {
    header("Location: index.php");
  }
?>

<div class="container">
  <h3>Admin Panel</h3>
  <div class="row">
    <h4>Korisnici</h4>
    <div class="table-responsive">
      <table class="table table-dark table-striped table-sm">
        <thead>
          <tr>
            <th>ID Korisnika</th>
            <th>Korisnicko Ime</th>
            <th>E-Mail</th>
            <th>Sifra</th>
            <th>Uloga</th>
            <th>Datum Registracije</th>
            <th>Brisanje</th>
            <th>Editovanje</th>
          </tr>
        </thead>
        <tbody id="adminKorisnici">
          <?php
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
              echo $ispisKorisnici;
            }
          ?>
        </tbody>
      </table>
    </div>
    <div id="formaZaEditKor"></div>
    <div id="formaZaInsertKor">
      <?php $ispisFormeKorisnik = "
        <form>
          <h1 class=\"h3 mb-3 fw-normal\">Unos korisnika</h1>
          <input type=\"text\" id=\"unosKorisnikUser\" class=\"form-control\" placeholder=\"Korisnicko ime\" required>
          <input type=\"password\" id=\"unosKorisnikPass\" class=\"form-control\" placeholder=\"Sifra\" required>
          <input type=\"email\" id=\"unosKorisnikMail\" class=\"form-control\" placeholder=\"E-mail\"  required>
          <select class=\"form-control\" id=\"unosKorisnikRole\">
            <option value=\"1\" selected>Admin</option>
            <option value=\"2\">Korisnik</option>
          </select>
          <input type=\"button\" id=\"unosKorisnikNov\" class=\"w-100 btn btn-lg btn-primary\" value=\"Unesi\"/>
        </form>";
        echo $ispisFormeKorisnik;
      ?>
    </div>
  </div>

  <div class="row">
    <h4>Prijave</h4>
    <div class="table-responsive">
      <table class="table table-dark table-striped table-sm">
        <thead>
          <tr>
            <th>ID Prijave</th>
            <th>Korisnik</th>
            <th>Prijavljeno Vreme</th>
            <th>Link za Video</th>
            <th>Komentar</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="adminPrijave">
          <?php
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
              echo $ispisPrijava;
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <h4>Leaderboards</h4>
    <div class="table-responsive">
      <table class="table table-dark table-striped table-sm">
        <thead>
          <tr>
            <th>Mesto</th>
            <th>Igrac</th>
            <th>Vreme</th>
            <th>Link</th>
            <th>Obrisi</th>
          </tr>
        </thead>
        <tbody id="adminLead">
          <?php
          //ispis tabele leaderboard
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
            echo $ispisLead;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <h4>Kontakt</h4>
    <div class="table-responsive">
      <table class="table table-dark table-striped table-sm">
        <thead>
          <tr>
            <th>ID Kontakt</th>
            <th>Naslov</th>
            <th>Mail</th>
            <th>Datum</th>
            <th>Poruka</th>
            <th>Brisanje</th>
          </tr>
        </thead>
        <tbody id="adminKontakt">
          <?php
          //ispis tabele kontakt id naslov mail datum text
          $tabela = vratiSve("kontakt");
          if($tabela){
            $ispisKontakt = "";
            foreach($tabela as $red){
              $idKontakt = $red->idKontakt;
              $naslovKontakt = $red->naslovKontakt;
              $mailKontakt = $red->mailKontakt;
              $datumKontakt = $red->datumKontakt;
              $textKontakt = $red->textKontakt;
              $ispisKontakt .= "<tr><td>$idKontakt</td><td>$naslovKontakt</td><td>$mailKontakt</td><td>$datumKontakt</td><td>$textKontakt</td>";
              $ispisKontakt .= "<td><a href='#' data-id='$idKontakt' class='obrisiKontakt btn btn-danger'>Obrisi</a></td></tr>";
            }
            echo $ispisKontakt;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row" id="anketaAdmin">
    <h4>Ankete</h4>
    <?php
      $upit = "SELECT * FROM ankete";
      $rez = $konekcija->query($upit)->fetchAll();
      $ispis = "<table class=\"table table-dark table-striped table-sm\"><thead><tr><th>ID Ankete</th><th>Pitanje</th><th>Izmeni</th></tr></thead>";
      foreach($rez as $red){
        $ispis.= "<tr><td>$red->idAnketa</td><td>$red->pitanjeAnketa</td><td>";
        if($red->aktivnaAnketa){
          $ispis.= "<a href='#' data-id='$red->idAnketa' class='deaktiviraj btn btn-danger'>Deaktiviraj</a>";
        }else{
          $ispis.= "<a href='#' data-id='$red->idAnketa' class='aktiviraj btn btn-success'>Aktiviraj</a>";
        }
          $ispis.= "</td></tr>";
      }
      $ispis.= "</table>";
      echo $ispis;
    ?>
  </div>

  <div class="row">
    <h4>Rezultati Ankete</h4>
    <?php
      $upit = "SELECT pitanjeAnketa, userKorisnik, odgovorAnketa FROM rezultati r JOIN korisnici k ON r.idKorisnik = k.idKorisnik JOIN odgovori o ON r.idOdgovor = o.idOdgovor JOIN ankete a ON r.idAnketa = a.idAnketa ORDER BY a.idAnketa";
      $rez = $konekcija->query($upit)->fetchAll();
      $ispis = "<table class=\"table table-dark table-striped table-sm\"><thead><tr><th>Pitanje</th><th>Korisnik</th><th>Odgovor</th></tr></thead>";
      foreach($rez as $red){
        //ispisi tabelu
        $ispis.= "<tr><td>$red->pitanjeAnketa</td><td>$red->userKorisnik</td><td>$red->odgovorAnketa</td></tr>";
      }
      $ispis.= "</table>";
      echo $ispis;
    ?>
  </div>

  <div class="row">
    <h4>Trkaci</h4>
    <div class="table-responsive">
      <table class="table table-dark table-striped table-sm">
        <thead>
          <tr>
            <th>ID Trkac</th>
            <th>Ime Trkaca</th>
            <th>Slika</th>
            <th>Opis</th>
            <th>Youtube Link</th>
            <th>Brisanje</th>
            <th>Editovanje</th>
          </tr>
        </thead>
        <tbody id="adminTrkaci">
          <?php
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
              echo $ispisTrkaci;
            }
          ?>
        </tbody>
      </table>
    </div>
    <div id="izmenaTrkac"></div>
    <div id="unosTrkac" class="row">
      <form action="obrada/obradaAdminUpload.php" method="post" enctype="multipart/form-data">
        <h4>Unos novog Trkaca</h4>
        <input type="text" class="form-control" name="unosTrkacIme" placeholder="Ime" required>
        <textarea colls="10" rows="4" class="form-control" name="unosTrkacOpis" placeholder="Opis" required></textarea>
        <input type="text" class="form-control" name="unosTrkacLink1" placeholder="Youtube link" required>
        <input type="text" class="form-control" name="unosTrkacAlt" placeholder="Alt Slike Trkaca" required>
        <input type="file" name="unosTrkacSlika" >
        <input type="submit" value="Unos" name="unosTrkacDugme">
      </form>
      <div>
        <?php
          if(isset($_SESSION['uploadGreska'])){
            $greskaUpload = $_SESSION['uploadGreska'];
            echo "<p class='alert alert-danger'>$greskaUpload</p>";
            unset($_SESSION['uploadGreska']);
          }
        ?>
      </div>
    </div>
  </div>
</div>
<?php
  include "fixed/footer.php";
?>
<script type="text/javascript" src="js/mainAdmin.js"></script>