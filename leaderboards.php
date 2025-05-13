<?php
  include("konekcija.php");
  include("fixed/head.php");
  include("fixed/header.php");
  include("obrada/funkcije.php");
?>
<div class="container block-mg">
  <h3>Leaderboards</h3>
  <form id="searchForm">
    <h1 class="h3 mb-3 fw-normal">Pretraga</h1>
    <input type="text" id="searchText" class="form-control" placeholder="Pretrazite trkaca/vreme" required autofocus>
    <input type="button" id="searchDugme" class="w-100 btn btn-lg btn-primary" value="Pretrazi"/>
    <input type="button" id="resetDugme" class="w-100 btn btn-lg btn-primary" value="Prikazi sve"/>
  </form>
  <div class="table-responsive">
    <table class="table table-dark table-striped table-sm">
      <thead>
        <tr>
          <th>Mesto</th>
          <th>Igrac</th>
          <th>Vreme</th>
          <th>Link</th>
        </tr>
      </thead>
      <tbody id="zaPretragu">
        <?php
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
            echo $ispisLead;
          }
        ?>
      </tbody>
    </table>
  </div>
  <?php
    include "fixed/footer.php";
  ?>
</div>
<script type="text/javascript" src="js/mainLeader.js"></script>