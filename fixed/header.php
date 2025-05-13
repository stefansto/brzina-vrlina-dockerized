<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Brzina Vrlina</a>
    <button class="navbar-toggler" type="button" id="navDugme">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <?php 
          $upitMeni = "SELECT * FROM meni";
          $rezMeni = $konekcija->query($upitMeni);
          if($rezMeni){
            $podMeni = $rezMeni->fetchAll();
            $ispisMeni = "";
            foreach($podMeni as $meni){
              $linkMeni = $meni->linkMeni;
              $nazivMeni = $meni->nazivMeni;
              $loggedMeni = $meni->loggedMeni;
              if($loggedMeni == 1){
                if(isset($_SESSION['roleK'])){
                  $ispisMeni .= "<li class=\"nav-item\"><a class=\"nav-link\" href=".$linkMeni.">".$nazivMeni."</a></li>";
                }
              }else{
                $ispisMeni .= "<li class=\"nav-item\"><a class=\"nav-link\" href=".$linkMeni.">".$nazivMeni."</a></li>";
              }
            }

            if(isset($_SESSION['roleK'])){
              $ispisMeni .= "<li class=\"nav-item\"><a class=\"nav-link\" href=\"profil.php\">Profil</a></li>";
              if($_SESSION['roleK'] == 1){
                $ispisMeni .= "<li class=\"nav-item\"><a class=\"nav-link\" href=\"admin.php\">Admin Panel</a></li>";
              }
              $ispisMeni .= "<li class=\"nav-item\"><a class=\"nav-link\" href=\"obrada/odjava.php\">Odjava</a></li>";
            }else{
              $ispisMeni .= "<li class=\"nav-item\"><a class=\"nav-link\" href=\"login.php\">Prijava</a></li>";
              $ispisMeni .= "<li class=\"nav-item\"><a class=\"nav-link\" href=\"register.php\">Registracija</a></li>";
            }
            echo $ispisMeni;
          }
        ?>
      </ul>
    </div>
  </div>
</nav>