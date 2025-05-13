<?php
  include("konekcija.php");
  include("fixed/head.php");
  include("fixed/header.php");
  if(!isset($_SESSION['idK'])){
    header("Location: login.php");
  }
?>
<div class="container">
  <form id="prijavaForm">
    <h1 class="h3 mb-3 fw-normal">Prijavi vreme</h1>
    <input type="hidden" id="prijavaId" value="<?php echo $_SESSION['idK'];?>">
    <input type="text" id="prijavaVreme" class="form-control" placeholder="Vreme: 00:00:00" required autofocus>
    <input type="text" id="prijavaLink" class="form-control" placeholder="Link: https://youtube.com/" required>
    <textarea id="prijavaKomentar" colls="10" rows="10" class="form-control" placeholder="Komentar" required></textarea>
    <input type="button" id="prijavaDugme" class="w-100 btn btn-lg btn-primary" value="Prijavi Vreme"/>
  </form>
  <div id="odgovor"></div>
  <?php
    include "fixed/footer.php";
  ?>
</div> 
<script type="text/javascript" src="js/mainPrijava.js"></script>