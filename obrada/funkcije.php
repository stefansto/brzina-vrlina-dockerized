<?php
    //SELECT SVE
    function vratiSve($nazivTabele){
        global $konekcija;
        $upit = "SELECT * FROM $nazivTabele";
        $podaci = $konekcija->query($upit)->fetchAll();
        return $podaci;
    }

    //INSERT korisnici
    function upisUTabeluKorisnici($obradaUser, $obradaMail, $obradaPass){
        global $konekcija;
        $obradaRole = 2;
        $upit = "INSERT INTO korisnici(`userKorisnik`, `mailKorisnik`, `passKorisnik`, `roleKorisnik`) VALUES(:user, :mail, :pass, :rol)";
        $ps = $konekcija->prepare($upit);
        $ps->bindParam(":user", $obradaUser);
        $ps->bindParam(":mail", $obradaMail);
        $ps->bindParam(":pass", $obradaPass);
        $ps->bindParam(":rol", $obradaRole);
        $rez = $ps->execute();
        return $rez;
    }

    //INSERT prijave
    function upisUTabeluPrijave($obradaIme, $obradaVreme, $obradaLink, $obradaKomentar){
        global $konekcija;
        $upit = "INSERT INTO `prijave` (`idKorisnik`, `vreme`, `link`, `komentar`) VALUES (:idK, :vreme, :link, :komentar)";
        $ps = $konekcija->prepare($upit);
        $ps->bindParam(":idK", $obradaIme);
        $ps->bindParam(":vreme", $obradaVreme);
        $ps->bindParam(":link", $obradaLink);
        $ps->bindParam(":komentar", $obradaKomentar);
        $rez = $ps->execute();
        return $rez;
    }

    //INSERT kontakt
    function upisUTabeluKontakt($obradaNaslov, $obradaMail, $obradaText){
        global $konekcija;
        $upit = "INSERT INTO `kontakt`(`naslovKontakt`, `mailKontakt`, `textKontakt`) VALUES (:naslov, :mail, :textKont)";
        $ps = $konekcija->prepare($upit);
        $ps->bindParam(":naslov", $obradaNaslov);
        $ps->bindParam(":mail", $obradaMail);
        $ps->bindParam(":textKont", $obradaText);
        $rez = $ps->execute();
        return $rez;
    }

    //DELETE
    function obrisi($tabela, $imeKolone, $brojId){
        global $konekcija;
        $upit = "DELETE FROM $tabela WHERE $imeKolone = :brojId";
        $delete = $konekcija->prepare($upit);
        $delete->bindParam(":brojId", $brojId);
        $rez = $delete->execute();
        return $rez;
    }

    //APPROVE DENY
    function prijava($tabela, $imeKolone, $novPodatak, $idKolona, $brojId){
        global $konekcija;
        $upit = "UPDATE $tabela SET $imeKolone = :novPodatak WHERE $idKolona = :brojId";
        $ps = $konekcija->prepare($upit);
        $ps->bindParam(":novPodatak", $novPodatak);
        $ps->bindParam(":brojId", $brojId);
        $rez = $ps->execute();
        return $rez;
    }
?>