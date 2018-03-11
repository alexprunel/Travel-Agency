<?php include("head.php"); 


function getIDExcursie($ide) {
    global $connection;	    
    $query="SELECT IDExcursie FROM Excursie WHERE IDTransport = ".$ide."";
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


function countTrans(){
    global $connection;	    
    $query="SELECT COUNT(*) AS NR_Trans FROM Transport";
    $sth = $connection->prepare($query);
    $sth->execute();
    $row=$sth->fetch(PDO::FETCH_ASSOC);
    return $row['NR_Trans'];


}

if($_GET){
	if(isset($_GET['delete_id'])){
		$id=$_GET['delete_id'];
		$query="DELETE FROM Transport WHERE IDTransport=".$id."";
		$sth = $connection->prepare($query);
		$sth->execute();
		if(getIDExcursie($id)){
			$ide = getIDExcursie($id);
			$update ="UPDATE Excursie SET IDTransport = 0 WHERE Excursie.IDExcursie = ".$ide."";
			$sth = $connection->prepare($update);
			$sth->execute();
			echo "<script type='text/javascript'>alert('Excursia cu id-ul ".$ide." a ramas fara transport.Va rugam sa rezolvati aceasta problema!')</script>";
		}
	}

}


if(isset($_POST['adaug'])){
	if(countExcursie()!="0"&&countTrans()<countExcursie()){
		if($_POST['mijloc']!=""&&$_POST['firma']!=""&&$_POST['prettrans']!=""){
			$mijloc=$_POST['mijloc'];
			$firma=$_POST['firma'];
			$prettrans=$_POST['prettrans'];
			$query="INSERT INTO Transport (mijloc,firma,Pret) VALUES ('".$mijloc."','".$firma."','".$prettrans."')";
			$sth = $connection->prepare($query);
			$sth->execute();
			}
	}
	else if(countExcursie()=="0") echo "<script type='text/javascript'>alert('Momentan nu exista nicio excursie in baza de date a companiei.')</script>";
	else if(countExcursie()==countTrans()) echo "<script type='text/javascript'>alert('Toate excursiile disponibile au transport.')</script>";
		
	
}
	if(isset($_POST['edit'])){
	if($_POST['mijloc']!=""&&$_POST['firma']!=""&&$_POST['prettrans']!=""){
		$mijloc=$_POST['mijloc'];
		$firma=$_POST['firma'];
		$prettrans=$_POST['prettrans'];
		$cid=$_POST['cid'];
		$query="UPDATE Transport SET mijloc='".$mijloc."',firma='".$firma."',Pret='".$prettrans."' WHERE IDTransport=".$cid."";
		$sth = $connection->prepare($query);
		$sth->execute();
		
		
	}
}

?>


<form action="transport.php" method="post">
Adaugare<br>Mijloc:<input type="text" name="mijloc"/><br>
Firma:<input type="text" name="firma"/>
Pret Transport:<input type="text"  name="prettrans" />
<input type="submit"  name="adaug" value="+"/><br>
</form>
<br>
<form action="transport.php" method="post">
Editare<br>Transport:<select name="cid">
<?php    
$query="SELECT IDTransport, mijloc,firma FROM Transport";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<option value='".$row['IDTransport']."'>";
		$output.=$row['mijloc'];
		$output.=" ";
		$output.=$row['firma'];	
		$output.="</option>";
		echo($output);
	}
}

?>
<br>
</select>
Mijloc:<input type="text" name="mijloc"/><br>
Firma:<input type="text" name="firma"/>
Pret Transport:<input type="text"  name="prettrans"/>
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
	<th>IDTransport</th>
	<th>Mijloc</th>
	<th>Firma</th>
	<th>Destinatie</th>
	<th>Pret Transport</th>
	</tr>
<?php
$query="SELECT T.IDTransport, T.Mijloc,T.Firma,E.Destinatie AS dest, T.Pret
        FROM Transport T LEFT JOIN Excursie E ON T.IDTransport = E.IDTransport";
$sth = $connection->prepare($query);
$sth->execute();
$rows = $sth->rowCount();
if(count($rows)>0){
	while($row=$sth->fetch(PDO::FETCH_ASSOC)){
		$output="<tr><td>";
		$output.=$row['IDTransport'];
		$output.="</td><td>";
		$output.=$row['Mijloc'];	
		$output.="</td><td>";
		$output.=$row['Firma'];
		$output.="</td><td>";
		$output.=$row['dest'];
		$output.="</td><td>";
		$output.=$row['Pret'];
		$output.="$</td><td>";
		$output.="<button><a href='transport.php?delete_id=".$row['IDTransport']."'>X</a></button>";
		$output.="</td></tr>";
		echo($output);
	}
}

?>
</table>
<br>

<?php include("footer.php"); ?>

























