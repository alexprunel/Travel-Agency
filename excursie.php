<?php include("head.php"); 

error_reporting(0);
@ini_set('display_errors', 0);

function calcPret($idc, $idt){
 	global $connection;	    
	$query="SELECT SUM(Pret) AS Pret FROM 
			(SELECT Cazare.Pret FROM Cazare WHERE IDCazare ='".$idc."'
                         UNION 
                         SELECT Transport.Pret FROM Transport WHERE IDTransport='".$idt."') T;";
	$sth = $connection->prepare($query);
    	$sth->execute();
    	$row=$sth->fetch(PDO::FETCH_ASSOC);
    	return $row['Pret'];
}


function getIDCazare($id){
	global $connection;
	$query="SELECT IDCazare FROM Excursie WHERE IDExcursie='".$id."'";
	$sth = $connection->prepare($query);
	$sth->execute();
	$row=$sth->fetch(PDO::FETCH_ASSOC);
	return $row['IDCazare'];
}


function getIDTransport($id){
	global $connection;
	$query="SELECT IDTransport FROM Excursie WHERE IDExcursie='".$id."'";
	$sth = $connection->prepare($query);
	$sth->execute();
	$row=$sth->fetch(PDO::FETCH_ASSOC);
	return $row['IDTransport'];
}

if($_GET){
	if(isset($_GET['delete_id'])){
		$id=$_GET['delete_id'];
		$idc=getIDCazare($id);
		$query="DELETE FROM Cazare WHERE IDCazare='".$idc."'";
		$sth = $connection->prepare($query);
		$sth->execute();
		$idt=getIDTransport($id);
		$query="DELETE FROM Transport WHERE IDTransport='".$idt."'";
		$sth = $connection->prepare($query);
		$sth->execute();
		$query="DELETE FROM Excursie WHERE IDExcursie='".$id."'";
		$sth = $connection->prepare($query);
		$sth->execute();		
		$query="DELETE FROM Vacanta WHERE IDExcursie='".$id."'";
		$sth = $connection->prepare($query);
		$sth->execute();
		
		
	}
	
}

if(isset($_POST['adaug'])){
	if($_POST['dataplec']!=""&&$_POST['datasosire']!=""&&$_POST['destinatie']!=""){
		$dataplec=$_POST['dataplec'];
		$datasosire=$_POST['datasosire'];
		$destinatie=$_POST['destinatie'];
		$idt=$_POST['idt'];
		$idc=$_POST['idc'];
		$query="INSERT INTO Excursie (DataPlecare,DataSosire,Destinatie,Pret,IDCazare,IDTransport) VALUES ('".$dataplec."','".$datasosire."','".$destinatie."','".calcPret($idc, $idt)."','".$idc."','".$idt."')";
		$sth = $connection->prepare($query);
		$sth->execute();
		}
		
	
}
if(isset($_POST['edit'])){
	if($_POST['dataplec']!=""&&$_POST['datasosire']!=""&&$_POST['destinatie']!=""){
		$dataplec=$_POST['dataplec'];
		$datasosire=$_POST['datasosire'];
		$destinatie=$_POST['destinatie'];
		$id=$_POST['id'];
		$idt=$_POST['idt'];
		$idc=$_POST['idc'];
		$query="UPDATE Excursie SET DataPlecare='".$dataplec."',DataSosire='".$datasosire."',Destinatie='".$destinatie."',Pret='".calcPret($idc, $idt)."',IDCazare='".$idc."',IDTransport='".$idt."' WHERE IDExcursie=".$id."";
		$sth = $connection->prepare($query);
		$sth->execute();
		
		
	}
}

	


?>
<br>
<form action="excursie.php" method="post">
Adaugare<br>Destinatie:<input type="text" name="destinatie"/><br>
Data Plecare:<input type="date"  name="dataplec"/><br>
Data Sosire:<input type="date"  name="datasosire"/>
Transport:<select name="idt">
<?php    
$query="SELECT IDTransport,Mijloc,Firma FROM Transport";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<option value='".$row['IDTransport']."'>";
		$output.=$row['Mijloc'];
		$output.=" ";
		$output.=$row['Firma'];
		$output.="</option>";
		echo($output);
	}
}

?>
</select>
Cazare:<select name="idc">
<?php    
$query="SELECT IDCazare,Locatie,Hotel FROM Cazare";
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
<input type="submit"  name="adaug" value="+"/>
</form>
<br>
<form action="excursie.php" method="post">
Editare<br>
Excursii disponibile:<select name="id">
<?php    
$query="SELECT IDExcursie,Destinatie FROM Excursie";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<option value='".$row['IDExcursie']."'>";
		$output.=$row['Destinatie'];
		$output.="</option>";
		echo($output);
	}
}

?>
</select><br>
Editare: Destinatie:<input type="text" name="destinatie"/><br>
Data Plecare:<input type="date"  name="dataplec"/><br>
Data Sosire:<input type="date"  name="datasosire"/>
Transport:<select name="idt">
<?php    
$query="SELECT IDTransport,Mijloc,Firma FROM Transport";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<option value='".$row['IDTransport']."'>";
		$output.=$row['Mijloc'];
		$output.=" ";
		$output.=$row['Firma'];
		$output.="</option>";
		echo($output);
	}
}

?>
</select>
Cazare:<select name="idc">
<?php    
$query="SELECT IDCazare,Locatie,Hotel FROM Cazare";
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
<input type="submit"  name="edit" value="Edit"/>
</form>
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
	<th>Destinatie</th>
	<th>Data Plecare</th>
	<th>Data Sosire</th>
	<th>Cazare</th>
	<th>Transport</th>
	<th>Pret</th>
	</tr>
<?php
$query="SELECT E.IDExcursie,E.Destinatie,E.DataPlecare,E.DataSosire,C.Hotel,T.Firma,E.Pret
	FROM Excursie E LEFT JOIN Cazare C ON C.IDCazare = E.IDCazare
			LEFT JOIN Transport T ON T.IDTransport=E.IDTransport
	ORDER BY E.DataPlecare;";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<tr><td>";
		$output.=$row['Destinatie'];
		$output.="</td><td>";
		$output.=$row['DataPlecare'];
		$output.="</td><td>";
		$output.=$row['DataSosire'];
		$output.="</td><td>";
		$output.=$row['Hotel'];
		$output.="</td><td>";
		$output.=$row['Firma'];
		$output.="</td><td>";
		$output.=$row['Pret'];
		$output.="$</td><td>";
		$output.="<button><a href='excursie.php?delete_id=".$row['IDExcursie']."'>X</a></button>";
		$output.="</td></tr>";
		echo($output);
	}
}

?>
</table>
<br>

<?php include("footer.php"); ?>
