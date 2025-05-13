<?php
  include("konekcija.php");
  include("fixed/head.php");
  include("fixed/header.php");
?>
<div class="container">
  <form>
    <h1 class="h3 mb-3 fw-normal">Registracija</h1>
    <input type="text" id="regUser" class="form-control" placeholder="Korisnicko ime" required autofocus>
    <input type="email" id="regMail" class="form-control" placeholder="E-mail" required>
    <input type="password" id="regPass" class="form-control" placeholder="Sifra" required>
    <input type="password" id="regPass2" class="form-control" placeholder="Sifra" required>
    <input type="button" id="regDugme" class="w-100 btn btn-lg btn-primary" value="Registruj Se"/>
  </form>
  <div id="odgovor" class="logreg"></div>
  <?php
    include "fixed/footer.php";
  ?>
</div> 
<script type="text/javascript" src="js/mainReg.js"></script>