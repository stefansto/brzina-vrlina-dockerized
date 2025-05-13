<?php
  include("konekcija.php");
  include("fixed/head.php");
  include("fixed/header.php");
?>
<div class="container">
  <form>
    <h1 class="h3 mb-3 fw-normal">Kontaktirajte Nas</h1>
    <input type="text" id="kontNaslov" class="form-control" placeholder="Naslov" required autofocus>
    <input type="email" id="kontMail" class="form-control" placeholder="Mail" required>
    <textarea id="kontText" colls="10" rows="10" class="form-control" placeholder="Text" required></textarea>
    <input type="button" id="kontDugme" class="w-100 btn btn-lg btn-primary" value="Posalji"/>
  </form>
  <div id="odgovor"></div>
  <?php
    include "fixed/footer.php";
  ?>
</div>
<script type="text/javascript" src="js/mainKont.js"></script>