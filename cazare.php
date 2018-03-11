<?php include("head.php"); 


function getIDExcursie($ide) {
    global $connection;	    
    $query="SELECT IDExcursie FROM Excursie WHERE IDCazare = ".$ide."";
    $sth = $connection->prepare($query);
    $sth->execute();
    $row=$sth->fetch(PDO::FETCH_ASSOC);
    return $row['IDExcursie'];
}

function countExcursie(){
    global $connection;	    
    $query="SELECT COUNT(*) AS NR_Excursii FROM Excursie";
    $sth = $connection->prepare($query);
    $sth->execute();
    $row=$sth->fetch(PDO::FETCH_ASSOC);
    return $row['NR_Excursii'];


}

function getNrCazariIdem(){
    global $connection;	    
    $query="SELECT COUNT(*) AS Cazari_idem FROM Cazare
	W";
    $sth = $connection->prepare($query);
    $sth->execute();
    $row=$sth->fetch(PDO::FETCH_ASSOC);
    return $row['NR_Excursii'];


}

function countCazari(){
    global $connection;	    
    $query="SELECT COUNT(*) AS NR_Cazari FROM Cazare";
    $sth = $connection->prepare($query);
    $sth->execute();
    $row=$sth->fetch(PDO::FETCH_ASSOC);
    return $row['NR_Cazari'];


}



if($_GET){
	if(isset($_GET['delete_id'])){
		$id=$_GET['delete_id'];
		$query="DELETE FROM Cazare WHERE IDCazare=".$id."";
		$sth = $connection->prepare($query);
		$sth->execute();
		if(getIDExcursie($id)){
			$ide = getIDExcursie($id);
			$update ="UPDATE Excursie SET IDCazare = 0 WHERE Excursie.IDExcursie = ".$ide."";
			$sth = $connection->prepare($update);
			$sth->execute();
			echo "<script type='text/javascript'>alert('Excursia cu id-ul ".$ide." a ramas fara cazare.Va rugam sa rezolvati aceasta problema!')</script>";
		}
		
	}
	
	
}


if(isset($_POST['adaug'])){
	if(countExcursie()!="0"&&countCazari()<countExcursie()){
		if($_POST['locatie']!=""&&$_POST['hotel']!=""&&$_POST['pretcazare']!=""){
			$locatie=$_POST['locatie'];
			$hotel=$_POST['hotel'];
			$pretcazare=$_POST['pretcazare'];
			$query="INSERT IGNORE INTO Cazare (Locatie,Hotel,Pret) VALUES ('".$locatie."','".$hotel."','".$pretcazare."')";
			$sth = $connection->prepare($query);
			$sth->execute();
			}
	}
	else if(countExcursie()=="0") echo "<script type='text/javascript'>alert('Momentan nu exista nicio excursie in baza de date a companiei.')</script>";
	else if(countExcursie()==countCazari()) echo "<script type='text/javascript'>alert('Toate excursiile disponibile au cazare.')</script>";

	
}
if(isset($_POST['edit'])){
	if($_POST['locatie']!=""&&$_POST['hotel']!=""&&$_POST['pretcazare']!=""){
		$locatie=$_POST['locatie'];
		$hotel=$_POST['hotel'];
		$pretcazare=$_POST['pretcazare'];
		$cid=$_POST['cid'];
		$query="UPDATE Cazare SET Locatie='".$locatie."',Hotel='".$hotel."',Pret='".$pretcazare."' WHERE IDCazare=".$cid."";
		$sth = $connection->prepare($query);
		$sth->execute();
		
		
	}
}

?>


<form action="cazare.php" method="post">
Adaugare<br> Locatie:<select name="locatie">
<?php    
$query="SELECT IDExcursie,Destinatie FROM Excursie";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<option value='".$row['Destinatie']."'>";
		$output.=$row['Destinatie'];
		$output.="</option>";
		echo($output);
	}
}

?>
</select>
Hotel:<input type="text" name="hotel"/><br>
Pret Cazare:<input type="text"  name="pretcazare" /><br>
<input type="submit"  name="adaug" value="+"/>
</form>

<form action="cazare.php" method="post">
Editare<br>Cazare:<select name="cid">
<?php    
$query="SELECT IDCazare, Locatie,Hotel FROM Cazare";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<option value='".$row['IDCazare']."'>";
		$output.=$row['Locatie'];
		$output.=" ";
		$output.=$row['Hotel'];	
		$output.="</option>";
		echo($output);
	}
}

?>
</select>
Locatie:<input type="text" name="locatie"/>
Hotel:<input type="text" name="hotel"/>
Pret Cazare:<input type="text"  name="pretcazare"/>
<input type="submit"  name="edit" value="Edit"/>
</form>



<br />
<style>
table, th, td {
    border: 2px solid black;
    margin-top:100px;  
   

}
</style>
<table align="center"style="width:auto">
	<tr>
	<th>IDCazare</th>
	<th>Locatie</th>
	<th>Hotel</th>
	<th>Pret Cazare</th>
	</tr>
<?php

$query="SELECT C.IDCazare,E.Destinatie AS Locatie,C.Hotel,C.Pret
	FROM Cazare C LEFT JOIN Excursie E ON C.IDCazare = E.IDCazare
	ORDER BY Locatie,C.IDCazare";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<tr><td>";
		$output.=$row['IDCazare'];
		$output.="</td><td>";
		$output.=$row['Locatie'];
		$output.="</td><td>";
		$output.=$row['Hotel'];
		$output.="</td><td>";
		$output.=$row['Pret'];
		$output.="$</td><td>";
		$output.="<button><a href='cazare.php?delete_id=".$row['IDCazare']."'>X</a></button>";
		$output.="</td></tr>";
		echo($output);
		
	}
}

?>
</table>
<br>


<?php include("footer.php"); ?>
























