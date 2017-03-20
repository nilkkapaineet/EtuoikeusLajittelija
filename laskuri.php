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
$query = 'select category, privi, rating from privileges';
$result = $conn->query($query);
$kokosumma = 0;
if ($result->num_rows > 0) { 
	$i = 0;
	while($row = $result->fetch_assoc()) {
		$omi[$i] = $row["privi"];
		$cat[$i] = $row["category"];
		$rat[$i] = $row["rating"];
		$kokosumma += $rat[$i];
		array_push($kombo, $cat[$i], $omi[$i]);
		$i++;
	}
}

$kokoKA = round($kokosumma/($i+1));

$uniCat = array_unique($cat);

$formillekoko = $_POST["montako"];
for ($i=0;$i<$formillekoko;$i++) {
	$kat[$i] = $_POST["$i"];
}

$usersStr = implode("','", $kat); 

$query = "select * from privileges where privi in ('$usersStr')";
$result = $conn->query($query);
$summa = 0;
echo "Valitsemiesi taustatekij&ouml;iden etuoikeuslukemat:<p></p><table>";
if ($result->num_rows > 0) { 
	while($row = $result->fetch_assoc()) {
		$rat = $row["rating"];
		$omi = $row["privi"];
		$kat = $row["category"];
		echo "<tr><td>$kat</td><td>$omi</td><td>$rat</td></tr>";
		$summa += $rat;
	}
}
		$conn->close();	
$ka = $summa/12;
echo "<tr><td></td><td><b>keskiarvo</b></td><td><b>" . round($ka) . "</b></td></tr></table>";
echo "Kaikkien attribuuttien keskiarvo: $kokoKA<p></p>";
?>
<?php require('footer.php'); ?>
