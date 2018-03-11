<?php include("head.php"); 


if($_GET){
	if(isset($_GET['delete_id'])){
		$id=$_GET['delete_id'];
		$query="DELETE FROM Angajati WHERE IDAngajat=".$id."";
		$sth = $connection->prepare($query);
		$sth->execute();
	}

}


if(isset($_POST['adaug'])){
	if($_POST['nume']!=""&&$_POST['prenume']!=""&&$_POST['mail']!=""&&$_POST['pass']!=""&&$_POST['salariu']!=""){
		$nume=$_POST['nume'];
		$prenume=$_POST['prenume'];
		$mail=$_POST['mail'];
		$pass=$_POST['pass'];
		$salariu=$_POST['salariu'];
		$query="INSERT INTO Angajati (Nume,Prenume,Mail,Passwd,Salariu) VALUES ('".$nume."','".$prenume."','".$mail."','".$pass."','".$salariu."')";
		$sth = $connection->prepare($query);
		$sth->execute();
		}
		
	
}

if(isset($_POST['edit'])){
	if($_POST['nume']!=""&&$_POST['prenume']!=""&&$_POST['mail']!=""&&$_POST['pass']!=""&&$_POST['salariu']!=""){
		$nume=$_POST['nume'];
		$prenume=$_POST['prenume'];
		$mail=$_POST['mail'];
		$pass=$_POST['pass'];
		$salariu=$_POST['salariu'];
		$cid=$_POST['cid'];
		$query="UPDATE Angajati SET Nume='".$nume."',Prenume='".$prenume."',Mail='".$mail."',Passwd='".$pass."',Salariu='".$salariu."' WHERE IDAngajat=".$cid."";
		$sth = $connection->prepare($query);
		$sth->execute();
		
		
	}
}

?>


<form action="angajati.php" method="post">
Adaugare<br>Nume:<input type="text" name="nume"/>
Prenume:<input type="text" name="prenume"/><br>
Mail:<input type="text"  name="mail" />
Password:<input type="text" name="pass"/><br>
Salariu:<input type="text"  name="salariu" />
<input type="submit"  name="adaug" value="+"/>
</form>
<br>
<form action="angajati.php" method="post">
Editare<br>Angajat:<select name="cid">
<?php    
$query="SELECT IDAngajat, Nume, Prenume FROM Angajati";
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

<br>
Nume:<input type="text" name="nume"/>
Prenume:<input type="text" name="prenume"/><br>
Mail:<input type="text"  name="mail" />
Password:<input type="text" name="pass"/><br>
Salariu:<input type="text"  name="salariu" />
<input type="submit"  name="edit" value="Edit"/>
</form>



<br />
<br>
<form action="angajati.php" method="post">
Nume:<select name="ida">
<?php    
$query="SELECT IDAngajat, Nume, Prenume FROM Angajati";
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
<input type="submit"  name="cauta" value="Cauta"/>
</form>
<?php
if(isset($_POST['cauta'])){
	
		$ida=$_POST['ida'];
		$query="SELECT A.IDAngajat, A.Nume, A.Prenume,A.Salariu, 
			(SELECT COUNT(*)
			FROM Clienti WHERE IDAngajat=A.IDAngajat) AS Nr_Clienti
       			FROM Angajati A
      			WHERE A.IDAngajat='".$ida."';
       			ORDER BY Nr_Clienti;";
		$sth = $connection->prepare($query);
		$sth->execute();
		$row=$sth->fetch(PDO::FETCH_ASSOC);
		echo "Numele angajatului este ".$row['Nume']." ".$row['Prenume'].", are un salariu de ".$row['Salariu']."$ si s-a ocupat de ".$row['Nr_Clienti']." clienti.";
		
}
?>
<br>
<br>

<form action="angajati.php" method="post">


<table style="width:auto" border=2px>
	<tr>Angajatii companiei
	<th>Nume</th>
	<th>Prenume</th>
	<th>Mail</th>
	<th>Password</th>
	<th>Salariu</th>
	<th>Nr Clienti</th>
	</tr>
<?php
$query="SELECT A.IDAngajat, A.Nume, A.Prenume, A.Mail, A.Passwd, A.Salariu, 
			(SELECT COUNT(*)
			FROM Clienti WHERE IDAngajat=A.IDAngajat) AS Nr_Clienti
       FROM Angajati A
       ORDER BY Nr_Clienti;";
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
		$output.=$row['Mail'];
		$output.="</td><td>";
		$output.=$row['Passwd'];
		$output.="</td><td>";
		$output.=$row['Salariu'];
		$output.="$</td><td>";
		$output.=$row['Nr_Clienti'];
		$output.="</td><td>";
		$output.="<button><a href='angajati.php?delete_id=".$row['IDAngajat']."'>X</a></button>";
		
		
		$output.="</td></tr>";
		echo($output);
	}
}

?>


</table>
<br />
<table border = 2px  style="width:auto">
<tr>Lista celor mai bine platiti angajati.
<th>Nume</th>
<th>Prenume</th>
<th>Salariu</th>
</tr>
<?php
$query="SELECT Nume,Prenume, Salariu
	FROM Angajati JOIN (SELECT DISTINCT Salariu Sal
      	FROM Angajati
     	ORDER BY Salariu DESC
      	LIMIT 2, 1) x
	ON Salariu >= Sal
	ORDER by Salariu DESC,Nume;";
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
		$output.=$row['Salariu'];
		$output.="$</td></td>";
		
		echo($output);
	}
}

?>
</table>
<br>




<?php include("footer.php"); ?>

