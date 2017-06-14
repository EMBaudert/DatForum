<?PHP
   if(isset($_SESSION["logged"])&&$_SESSION["logged"]){

   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
	$sql = "SELECT * FROM user WHERE PKID_user='".$_SESSION["PKID"]."'";
	
	$user = $pdo->query($sql);
	$user->execute();
	$data=$user->fetch();
   
	
   



if (isset($_GET["a"])){

   $filename="pic/pb_".$_SESSION["PKID"].".png";
   move_uploaded_file($_FILES['datei']['tmp_name'], $filename);
   #echo "<script>alert('Der Upload war erfolgreich!')</script>";
   session_destroy();
   session_start();
   $_SESSION["logged"]=TRUE;
}
   $_SESSION["firstname"]=$data["firstname"];	
	$_SESSION["secondname"]=$data["secondname"];	
	$_SESSION["username"]=$data["username"];	
	$_SESSION["email"]=$data["email"];	
   $_SESSION["PKID"]=$data["PKID_user"];
   
   
?>

<h1>Profil</h1>
<form action="intern.php?p=profile&a=change" method="POST" enctype="multipart/form-data"><br />
<p><img src="<?PHP echo $_SESSION["pb_path"]; ?>.png" width="350px" /></p>
<div style="width:60%;top:100px;left:40%;">
Neues Profilbild<input type="file" name="datei"><br><br>
<table width=50%>
<tr>
<td>Benutzername:</td><td><?PHP if(isset($_SESSION["username"])){echo $_SESSION["username"]; }?></td>
</tr>
<tr>
<td>Vorname:</td><td><input type="text" name="firstname" value="<?PHP if(isset($_SESSION["firstname"])){echo $_SESSION["firstname"]; }?>"></td>
</tr>
<tr>
<td>Nachname:</td><td><input type="text" name="secondname" value="<?PHP if(isset($_SESSION["secondname"])){echo $_SESSION["secondname"]; }?>"></td>
</tr>
<tr>
<td>E-Mail Adresse:</td><td><input type="text" name="email" value="<?PHP if(isset($_SESSION["email"])){echo $_SESSION["email"]; }?>"></td>
</tr>
<tr>
<td></td><td><br><input name="submit" type="submit" value=" &Auml;nderungen speichern"></td>
</tr>
</table>
</div>
</form>

<?PHP  
   }else{
      echo "<h1>Bitte melden Sie sich an!</h1>";
   }
?>