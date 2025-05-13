<?php
    include("konekcija.php");
    include("fixed/head.php");
    include("fixed/header.php");
    include("obrada/funkcije.php");
?>

<div class="container block-mg">
    <div class="row" id="trkaci">
        <h3>Poznati Trkaci!</h3>
        <?php
            $koliko_po_strani = 3;
            $skriveno = 0;
            if(isset($_GET['skriveno'])){
                $skriveno = $_GET['skriveno'];
            }else{
                $skriveno = 0;
            }
            $upit = $konekcija->query("SELECT count(idTrkac) from trkaci");
            $niz = $upit->fetchAll(PDO::FETCH_COLUMN, 0);

            $ukupno_zapisa = $niz[0];
            $levo = $skriveno - $koliko_po_strani;
            $desno = $skriveno + $koliko_po_strani;

            $upit = "SELECT * FROM trkaci LIMIT $koliko_po_strani OFFSET $skriveno";
            $rezultat = $konekcija->query($upit);

            foreach($rezultat as $red){
                echo "
                <div class=\"card bg-dark \" style=\"max-width: 15rem;\">
                    <img class=\"card-img-top\" src=\"$red->slikaTrkac\" alt=\"Card image cap\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">$red->imeTrkac</h5>
                        <p class=\"card-text\">$red->opisTrkac</p>
                    </div>
                    <div class=\"card-body\">
                        <a href=\"$red->link1Trkac\" class=\"card-link linkovi\">$red->link1Trkac</a>
                    </div>
                </div>";
            }
            echo "<div class=\"dugmad strane row\">";
            if($levo<0){
                echo ("<div class=\"col align-self-end\"><p class=\"text-primary\"><a href=\"trkaci.php?skriveno=$desno\" class=\"strane straneDugme\">Naredni</a></p></div>");
            }else if($desno > $ukupno_zapisa){
                echo ("<div class=\"col align-self-start\"><p class=\"text-primary\"><a href=\"trkaci.php?skriveno=$levo\" class=\"strane straneDugme\">Prethodni</a></p></div>");
            }else{
                echo ("<div class=\"col align-self-start\"><p class=\"text-primary\"><a href=\"trkaci.php?skriveno=$levo\" class=\"strane straneDugme\">Prethodni</a></p></div>");
                echo ("<div class=\"col align-self-end\"><p class=\"text-primary\"><a href=\"trkaci.php?skriveno=$desno\" class=\"strane straneDugme\">Naredni</a></p></div>");
            }
            echo "</div>";
        ?>
    </div>
    <?php
        include "fixed/footer.php";
    ?>
</div>