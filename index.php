<?php

echo '
<head>
<title>Etuoikeuksien lajittelija</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';
header('Content-Type: text/html; charset=ISO-8859-1');

	require('dbConn.php');

	echo "Feminismin 3. aallon mukainen etuoikeuksien lajittelija<p></p>";
	echo 'Feminismin 3. aalto on keskittynyt erilaisten rakenteellisten etuoikeuksien perkaamiseen. Esimerkiksi homoseksuaalinen musliminainen kokee monelle tavalla syrjint&auml;&auml; ja sortoa enemm&auml;n kuin heteroseksuaalinen ateistimies. T&auml;m&auml;n verkkopalvelun jalona tavoitteena on pist&auml;&auml; erilaiset etuoikeutetut ja sorretut kategoriat j&auml;rjestykseen. Palvelu arpoo kaksi ryhm&auml;&auml;, joista sinun teht&auml;v&auml;si on valita se, joka on etuoikeutetummassa asemassa toiseen n&auml;hden. Jos koet ryhmien olevan yhteismitattomassa tilassa, voit sivuuttaa kysymyksen tai arpoa etuoikeutetumman aseman puhtaalla tunteella.';
	echo "<p>Valitse kahdesta k&auml;sitteest&auml; se, joka on etuoikeutetummassa asemassa. Ruksi valintalaatikko ja paina 'l&auml;het&auml;'. <p></p>";

	if (isset($_POST['privilege']) ) {
		$etuoikeus = $_POST['privilege'];
		// p&auml;ivit&auml; taulukko, laske muutoksen suuruus ja passaa se jotenkin t&auml;nne
		// noin, se tulee t&auml;llaisessa formaatissa: etuoikeusNRO#rating
		// ja koska pit&auml;&auml; p&auml;ivitt&auml;&auml; molemmat arvot, niin pit&auml;&auml; laittaa viel&auml; n&auml;in:
		// etuoikeus1#rating1#etuoikeus2#rating2
		// siis tuonne form kentt&auml;&auml;n...
		$postidata = explode("#", $etuoikeus);
		// $pd[0] = nro ja $pd[1] = rating
		
		$sql = "UPDATE privileges SET rating = CASE id WHEN $postidata[0] THEN $postidata[1] WHEN $postidata[2] THEN $postidata[3] END WHERE id IN ($postidata[0], $postidata[2]);";
		if ($conn->query($sql) === FALSE) {
			echo "Virhe muutettaessa tietokantaa: " . $conn->error;
		}
	}


	$query = 'select * from privileges order by rand() limit 0,2';
	$result = $conn->query($query);
	
	echo "<form action=\"index.php\" method=\"post\"> \n";

	if ($result->num_rows > 0) {
		$i = 0;
		while($row = $result->fetch_assoc()) {
			$nro[$i] = $row["id"];
			$privi[$i] = $row["privi"];
			$category[$i] = $row["category"];
			$rating[$i] = $row["rating"];
			$i++;
			// aivan, n&auml;m&auml; pit&auml;&auml; laittaa t&auml;&auml;ll&auml; ensin vain talteen ja tulostaa formi vasta myöhemmin, kun elo rating on jo laskettu molemmille tapauksille
		}
	}	

	//t&auml;ss&auml; v&auml;liss&auml; pit&auml;&auml; jo laskea ne reittaukset
	$elo1 = $rating[0];
	$elo2 = $rating[1];
	$ea = 1/(1+pow(10, (($elo2-$elo1)/400) ));
	$eb = 1/(1+pow(10, (($elo1-$elo2)/400) ));
	// 1 voittaa
	$ra1 = round($elo1 + 32*(1-$ea));
	$rb1 = round($elo2 + 32*(0-$eb));
	// 2 voittaa
	$ra2 = round($elo1 + 32*(0-$ea));
	$rb2 = round($elo2 + 32*(1-$eb));
	
	echo "<input type=radio name=privilege value=\"" . $nro[0]. "#" . $ra1. "#" . $nro[1]. "#". $rb1. "\">" . $category[0]. ": " . $privi[0]. "<br> \n";
	echo "<input type=radio name=privilege value=\"" . $nro[1]. "#" . $rb2. "#" . $nro[0]. "#". $ra2. "\">" . $category[1]. ": " . $privi[1]. "<br> \n";
	
	echo "<p></p><input type=\"submit\"><p></p>";
	
	$conn->close();

?>

<html>
<body>


Lajittelija k&auml;ytt&auml;&auml; shakista tuttua Elo-lukua eri etuoikeuksien vahvuuden m&auml;&auml;rittelyyn. 
Mit&auml; korkeamman vertailuluvun ryhm&auml; saa, sen etuoikeutetummassa asemassa ryhm&auml;n edustajat ovat. <p></p>
<?php require('footer.php'); ?>
</body>
</html>
