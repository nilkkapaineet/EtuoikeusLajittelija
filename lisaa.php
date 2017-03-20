<?php

echo '
<head>
<title>Etuoikeuksien lajittelija</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';
header('Content-Type: text/html; charset=ISO-8859-1');
require('dbConn.php');

if (isset($_POST['kategoria']) && isset($_POST['ominaisuus']) ) {
		$kat = $_POST['kategoria'];
		$omi = $_POST['ominaisuus'];
		
		$isql = "insert into privileges (category, privi, rating) values ('$kat', '$omi', 1200)";

		if ($conn->query($isql) === FALSE) {
			echo "Error: " . $isql . "<br>" . $conn->error;
		} else {
			echo "Ehdotuksesi lis&auml;tty tietokantaan. <a href=index.php>Palaa alkuun</a>";
		}

	$conn->close();

		
	} else {
		echo "Kentt&auml; j&auml; tyhj&auml;ksi. <a href=listaus.php>Palaa takaisin</a>";
	}
	
?>
<?php require('footer.php'); ?>
