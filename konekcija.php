<?php 
	$serverBaze = "mysql_db";
	$nazivBaze = "brzina";
	$username = "user";
	$password = "pass";
	try{
		$konekcija = new PDO("mysql:host=$serverBaze;dbname=$nazivBaze", $username, $password);
		$konekcija->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$konekcija->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	}catch(PDOException $e){
		echo "Greska sa konekcijom: $e";
	}
?>