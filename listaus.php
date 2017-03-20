<?php

echo '
<head>
<title>Etuoikeuksien lajittelija</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';
header('Content-Type: text/html; charset=ISO-8859-1');
require('dbConn.php');

	$query = 'select * from privileges order by rating desc';
	$result = $conn->query($query);
	
	echo "<table><tr><td>Sija</td><td>Kategoria</td><td>Ominaisuus</td><td>Elo-luku</td></tr>";
	if ($result->num_rows > 0) {
		$i = 1;
		while($row = $result->fetch_assoc()) {
			$nro = $row["id"];
			$privi = $row["privi"];
			$category = $row["category"];
			$rating = $row["rating"];
			echo "<tr><td>$i</td><td>$category</td><td>$privi</td><td>$rating</td></tr>";
			$i++;
		}
	}	
	echo "</table>";
	
	$conn->close();
	
	echo "<p></p>Ehdota uutta ominaisuutta: <br>";
	echo "<form action=\"lisaa.php\" method=\"post\"> \n";
	echo "<table><tr><td>Kategoria:</td><td><input type=text name=kategoria></td></tr>";
	echo "<tr><td>Ominaisuus:</td><td><input type=text name=ominaisuus></td></tr></table><p></p>";
	echo "<input type=submit>";
	echo "</form>";
require('footer.php'); 
