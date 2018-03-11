<?php include("head.php"); ?>
<h2>Lista excursionistilor</h2>
<table border="2">
<tr>
<th>Nume</th>
<th>Prenume</th>
<th>Varsta</th>
<th>Excursie</th>
<th></th>
</tr>
<?php
$query="SELECT C.Nume,C.Prenume,C.Varsta,E.Destinatie
	FROM Clienti C INNER JOIN Vacanta V ON C.IDClient=V.IDClieNt
		       INNER JOIN Excursie E ON E.IDExcursie=V.IDExcursie;";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<tr><td>";
		$output.=$row['Nume'];
		$output.="</td><td>";
		$output.=$row['Prenume'];
		$output.="</td><td>";
		$output.=$row['Varsta'];
		$output.="</td><td>";
		$output.=$row['Destinatie'];
		$output.="</td></td>";
		
		echo($output);
	}
}

?>
</table>
<br>
<br>
<table border="2">
<tr>
<th>Nume</th>
<th>Prenume</th>
<th>Destinatie</th>
<th>Firma transport</th>
<th></th>
</tr>
<?php
$query="SELECT C.Nume,C.Prenume,H.Locatie,T.Firma
	FROM Clienti C LEFT JOIN Vacanta V ON C.IDClient=V.IDClient
	LEFT JOIN Excursie E ON E.IDExcursie=V.IDExcursie
        LEFT JOIN Cazare H ON H.IDCazare=E.IDCazare
        LEFT JOIN Transport T ON T.IDTransport=E.IDTransport
	ORDER BY C.Nume,C.Prenume,H.Locatie;";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<tr><td>";
		$output.=$row['Nume'];
		$output.="</td><td>";
		$output.=$row['Prenume'];
		$output.="</td><td>";
		$output.=$row['Locatie'];
		$output.="</td><td>";
		$output.=$row['Firma'];
		$output.="</td></td>";
		
		echo($output);
	}
}

?>
</table>
<br>

<?php include("footer.php"); ?>
