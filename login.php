<?php
  include("konekcija.php");
  include("fixed/head.php");
  include("fixed/header.php");
?>
<div class="container">
  <form>
    <h1 class="h3 mb-3 fw-normal">Ulogujte se!</h1>
    <input type="text" id="logUser" class="form-control" placeholder="Korisnicko ime" required autofocus>
    <input type="password" id="logPass" class="form-control" placeholder="Sifra" required>  
    <input type="button" id="logDugme" class="w-100 btn btn-lg btn-primary" value="Uloguj se"/>
  </form>
  <div id="greska" class="bg-dark"></div>
  <?php
    include "fixed/footer.php";
  ?>
</div> 
<script type="text/javascript" src="js/mainLog.js"></script>