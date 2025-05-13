<footer class="footer py-3">
  <div class="container">
      <?php
        $upitFooter = "SELECT * FROM footer";
        $rezFoot = $konekcija->query($upitFooter);
        if($rezFoot){
          $podFoot = $rezFoot->fetchAll();
          $ispisFoot = "";
          foreach($podFoot as $red){
            $linkFooter = $red->linkFooter;
            $nazivFooter = $red->nazivFooter;
            $ispisFoot .= "<a class=\"nav-link footlink\" href=".$linkFooter.">".$nazivFooter."</a>";
          }
          echo $ispisFoot;
        }
      ?>
    <span class="text-muted">Study Project</span>
  </div>
</footer>