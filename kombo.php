<?php

echo '
<head>
<title>Etuoikeuksien lajittelija</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';
header('Content-Type: text/html; charset=ISO-8859-1');
require('dbConn.php');

$cat = array();
$kombo = array();
$query = 'select category, privi from privileges';
$result = $conn->query($query);
if ($result->num_rows > 0) { 
	$i = 0;
	while($row = $result->fetch_assoc()) {
		$omi[$i] = $row["privi"];
		$cat[$i] = $row["category"];
		array_push($kombo, $cat[$i], $omi[$i]);
		$i++;
	}
}
	$conn->close();
$uniCat = array_unique($cat);

echo "T&auml;ll&auml; laskurilla voit laskea kombinaatiopisteluvun etuoikeuksista erilaisille taustoille:<p></p>";

echo "<form action=\"laskuri.php\" method=\"post\"> <table>";
$indeksi = 0;
foreach ($uniCat as $uc) {
	echo "<tr><td>$uc:</td><td><select name=\"$indeksi\">";
	$indeksi++;
	$i = 1;
	foreach ($kombo as $k) {
		if (strcmp($k, $uc) == 0) {
			echo "<option value=\"$kombo[$i]\">" . $kombo[$i] . "</option>";
		}
		$i++;
	}
	echo "</select></td></tr>\n";
}
$forminkoko = count($uniCat);

echo "<td><input type=submit></td><td></td></tr></table>";
echo "<input type=hidden name=montako value=$forminkoko></form>";
?>
<?php require('footer.php'); ?>
