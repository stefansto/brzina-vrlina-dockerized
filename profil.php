<?php
  include("konekcija.php");
  include("fixed/head.php");
  include("fixed/header.php");
  include("obrada/funkcije.php");
?>
<div class="container block-mg">
  <h3>Vas Profil</h3>
  <p>Dobrodosli na vas profil! Ovde mozete videti vase prijave sa njihovim trenutnim statusom!</p>
  <?php
    if(isset($_SESSION['idK'])){
      $idKorisnika = $_SESSION['idK'];
      $upit = "prijave p JOIN korisnici k ON p.idKorisnik = k.idKorisnik WHERE p.idKorisnik = $idKorisnika";
      $tabela = vratiSve($upit);
      if($tabela){
        $ispisPrijava = "<table class=\"table table-dark table-striped table-sm\"><thead><tr><th>Broj Prijave</th><th>Prijavljeno Vreme</th><th>Link</th><th>Vas Komentar</th><th>Status</th></tr></thead><tbody>";
        $brojPrijave = 0;
        foreach($tabela as $red){
          $idKorisnik = $red->userKorisnik;
          $vreme = $red->vreme;
          $link = $red->link;
          $komentar = $red->komentar;
          $odobreno = $red->odobreno;
          $brojPrijave++;
          $idKor = $red->idKorisnik;
          $ispisPrijava .= "<tr><td>$brojPrijave</td><td>$vreme</td><td>$link</td><td>$komentar</td><td>";
          if($odobreno==null){
            $ispisPrijava .= "U obradi</td></tr>";
          }else if($odobreno==1){
            $ispisPrijava .= "Prihvaceno</td></tr>";
          }else {
            $ispisPrijava .= "Odbijeno</td></tr>";
          }
        }
        echo $ispisPrijava;
        echo "</table>";
      }else{
        echo "<p>Niste prijavili vreme</p>";
      }
    }else{
      header("Location: login.php");
    }
  ?>
  <?php
    include "fixed/footer.php";
  ?>
</div>