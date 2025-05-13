<?php
    include("konekcija.php");
    include("fixed/head.php");
    include("fixed/header.php");
    include("obrada/funkcije.php");
    if(!isset($_SESSION['roleK'])){
        header("Location: login.php");
    }
?>
<div class="container block-mg">
    <div class="row">
        <h3>Anketa</h3>
        <?php
            $pitanje = "SELECT idAnketa, pitanjeAnketa FROM ankete WHERE aktivnaAnketa=1";
            $rezPitanje = $konekcija->query($pitanje);
            $nizPitanje = $rezPitanje->fetchAll();
            if($nizPitanje){
                foreach($nizPitanje as $red){
                    $idTrenutneAnkete=$red->idAnketa;
                    echo "<form><table class=\"table table-dark table-striped table-sm\"><tr><th>".$red->pitanjeAnketa."</th></tr>";
                    $upit = "SELECT odgovorAnketa, idOdgovor FROM odgovori o, ankete a WHERE a.aktivnaAnketa = 1 AND a.idAnketa = o.idAnketa AND o.idAnketa = $idTrenutneAnkete";
                    $rezOdgovor = $konekcija->query($upit);
                    foreach($rezOdgovor as $red){
                        echo "<tr><td>$red->odgovorAnketa <input type='radio' name='odgovor$idTrenutneAnkete' id='odgovor' value=".$red->idOdgovor."></td></tr>";
                    }
                    echo "<tr><td><input type='button' class='glasaj' data-id='$idTrenutneAnkete' data-korisnik=".$_SESSION['idK']." value='Glasaj'> ";
                    echo "<input type='button' class='rezultati' data-id='$idTrenutneAnkete' value='Rezultati'></td></tr>";
                }
                $idTrenutneAnkete;
                echo "</table></form>";
            }else{
                echo "<p>Nema aktivne ankete trenutno!</p>";
            }
        ?>
    </div>
    <div id="ispisTabele" class="row"></div>
    <?php
        include "fixed/footer.php";
    ?>
</div>
<script type="text/javascript" src="js/mainAnketa.js"></script>