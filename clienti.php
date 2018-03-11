<?php include("head.php"); 
if($_GET){
	if(isset($_GET['delete_id'])){
		$id=$_GET['delete_id'];
		$query="DELETE FROM Vacanta WHERE IDClient=".$id."";
		$sth = $connection->prepare($query);
		$sth->execute();
		$query="DELETE FROM Clienti WHERE IDClient=".$id."";
		$sth = $connection->prepare($query);
		$sth->execute();
	}

}
	if(isset($_POST['adaugvacanta'])){
	if($_POST['ide']!=""&&$_POST['idc']!=""){
		$idc=$_POST['idc'];
		$ide=$_POST['ide'];
		$query="INSERT INTO Vacanta (IDClient, IDExcursie) VALUES ('".$idc."','".$ide."');";
		$sth = $connection->prepare($query);
		$sth->execute();
		$query="DELETE FROM Vacanta  
			WHERE IDVacanta IN (SELECT * FROM (SELECT IDVacanta FROM Vacanta 
                  			    GROUP BY IDClient,IDExcursie 
					    HAVING (COUNT(*) > 1) ) AS A);";
		
		$sth = $connection->prepare($query);
		$sth->execute();
		}
		
	
}


	if(isset($_POST['adaug'])){
	if($_POST['nume']!=""&&$_POST['prenume']!=""&&$_POST['varsta']!=""&&$_POST['idang']!=""){
		$nume=$_POST['nume'];
		$prenume=$_POST['prenume'];
		$varsta=$_POST['varsta'];
		$idang=$_POST['idang'];
		$query="INSERT INTO Clienti (Nume,Prenume,Varsta,IDAngajat) VALUES ('".$nume."','".$prenume."','".$varsta."','".$idang."')";
		$sth = $connection->prepare($query);
		$sth->execute();
		}
		
	
}

	if(isset($_POST['edit'])){
	if($_POST['nume']!=""&&$_POST['prenume']!=""&&$_POST['varsta']!=""&&$_POST['idang']!=""){
		$nume=$_POST['nume'];
		$prenume=$_POST['prenume'];
		$varsta=$_POST['varsta'];
		$idang=$_POST['idang'];
		$cid=$_POST['cid'];
		$query="UPDATE Clienti SET Nume='".$nume."',Prenume='".$prenume."',Varsta='".$varsta."',IDAngajat='".$idang."' WHERE IDClient=".$cid."";
		$sth = $connection->prepare($query);
		$sth->execute();
		
		
	}
}

?>


<form action="clienti.php" method="post">
<br>Adaugare<br>Nume:<input type="text" name="nume"/>
Prenume:<input type="text" name="prenume"/><br>
Varsta:<input type="text"  name="varsta" />
Angajat:<select name="idang">
<?php    
$query="SELECT IDAngajat,Nume,Prenume FROM Angajati;";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<option value='".$row['IDAngajat']."'>";
		$output.=$row['Nume'];
		$output.=" ";
		$output.=$row['Prenume'];
		$output.="</option>";
		echo($output);
	}
}

?>
</select>
<input type="submit"  name="adaug" value="+"/>
</form>
<br>

<form action="clienti.php" method="post">
Editare<br>Clienti:<select name="cid">
<?php    
$query="SELECT IDClient, Nume,prenume FROM Clienti";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<option value='".$row['IDClient']."'>";
		$output.=$row['Nume'];
		$output.=" ";
		$output.=$row['Prenume'];	
		$output.="</option>";
		echo($output);
	}
}

?>
</select>
Nume:<input type="text" name="nume"/>
Prenume:<input type="text" name="prenume"/><br>
Varsta:<input type="text"  name="varsta"/>
Angajat:<input type="text"  name="idang"/>
<input type="submit"  name="edit" value="Edit"/>
</form>
<br>

<form action="clienti.php" method="post">
Ce excursie doriti?<br>
Nume Prenume:<select name="idc">
<?php    
$query="SELECT IDClient, Nume,prenume FROM Clienti";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<option value='".$row['IDClient']."'>";
		$output.=$row['Nume'];
		$output.=" ";
		$output.=$row['Prenume'];	
		$output.="</option>";
		echo($output);
	}
}

?>
</select>
Destinatie:<select name="ide">
<?php    
$query="SELECT IDExcursie, Destinatie FROM Excursie";
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
</select>
<input type="submit"  name="adaugvacanta" value="+"/>
</form>

<br />
<style>
table, th, td {
    border: 2px solid black;
    margin-top:0px;  
   

}
</style>
<table align="center"style="width:auto">
	<tr>
	<th>IDClient</th>
	<th>Nume</th>
	<th>Prenume</th>
	<th>Varsta</th>
	<th>Angajat</th>
	</tr>
<?php
$query="SELECT IDClient, C.Nume,C.Prenume,C.Varsta,A.Nume AS Numea,A.Prenume AS Prenumea
	FROM Clienti C LEFT JOIN Angajati A ON C.IDAngajat=A.IDAngajat;";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<tr><td>";
		$output.=$row['IDClient'];
		$output.="</td><td>";
		$output.=$row['Nume'];
		$output.="</td><td>";
		$output.=$row['Prenume'];
		$output.="</td><td>";
		$output.=$row['Varsta'];
		$output.="</td><td>";
		$output.=$row['Numea']." ".$row['Prenumea'];
		$output.="</td><td>";
		$output.="<button><a href='clienti.php?delete_id=".$row['IDClient']."'>X</a></button>";
		$output.="</td></tr>";
		echo($output);
	}
}

?>
</table>
<br>

<?php include("footer.php"); ?>

























