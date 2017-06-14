<?php

function checklogin($user,$pass){
	$pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
	$sql = "SELECT * FROM user WHERE username='".$user."'";
	
	$temppass = $pdo->query($sql);
	$temppass->execute();
	$login=$temppass->fetch();
	if(isset($login["password"])&&$pass==$login["password"]){
      $_SESSION["PKID"]=$login["PKID_user"];
		return TRUE;
	} 
	else{
		if(!isset($login["password"])){
			echo "Benutzername existiert nicht!";
		}else{
			echo "Falsches Passwort!";
		}
		return FALSE;
	}
}

function checkpass(){
   $temppass = $_POST["password"];
	if(!isset($temppass)||$temppass==""){
      echo "<p>Bitte geben Sie ein Passwort ein!</p>";
		return FALSE;
	}
   if($temppass!=$_POST["password2"]){
      echo "<p>Die Passworte sind nicht gleich!</p>";
      return FALSE;
   }
   #Hier Konventionen für Passwörter
	return TRUE;
}

function checkusername(){
   $username=$_POST["username"];
	if(!isset($username)||$username==""){
      echo "<p>Bitte geben Sie einen Benutzernamen ein!</p>";
		return FALSE;
	}
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT username FROM user WHERE username='".$username."'";
	$tempuser = $pdo->query($sql);
	$tempuser->execute();
	$register=$tempuser->fetch();
   if(isset($register["username"])){
      echo "<p>Der Benutzername existiert schon!</p>";
      return FALSE;
   }
   //Ab hier Konventionen für den Benutzernamen!
   
   for ($i = 0; $i < strlen($username);)
   {
       if(substr($username, $i, 1)!=" "){
            $_SESSION["username"]=$username;
            return TRUE;
       }
       $i += 1;
   }
   //Testet, ob ein Zeichen außer Leerzeichen im Username steht
   echo "<p>Der Benutzername entspricht nicht den Konventionen!</p>";
	return FALSE;
}

function checkemail(){
	$emailadress=$_POST["email"];
   if(!isset($emailadress)||$emailadress==""){
      echo "<p>Bitte geben Sie eine E-Mail Adresse ein!</p>";
		return FALSE;
	}
   
   #Konventionen für E-Mail Adresse
   if (filter_var($emailadress, FILTER_VALIDATE_EMAIL)) { 
      $_SESSION["email"]=$emailadress;
	   return TRUE;
   }
   echo "<p>Die eingegebene E-Mail Adresse entspricht nicht den Konventionen!</p>";
   return FALSE;
   
   
}

function newuser(){
	$_SESSION["firstname"]=$_POST["firstname"];	
	$_SESSION["secondname"]=$_POST["secondname"];	
	$_SESSION["username"]=$_POST["username"];	
	$_SESSION["email"]=$_POST["email"];	
	$PASS = hash('sha512',$_POST["password"]);
	//$IDENT=15;
	$pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
 /*  $sql = "SELECT PKID_user FROM user";
   
	foreach($pdo->query($sql) as $row){
      $IDENT=$row["PKID_user"];
	}
   $IDENT=$IDENT+1;
 
   */
	$sql = "INSERT INTO user (username, firstname, secondname, email, password) VALUES ('".$_SESSION["username"]."', '".$_SESSION["firstname"]."','".$_SESSION["secondname"]."','".$_SESSION["email"]."','".$PASS."')";
	$statement = $pdo->prepare($sql);
	$statement->execute();   
}

function checkname(){
   $firstname=$_POST["firstname"];
   $secondname=$_POST["secondname"];
   if(!isset($firstname)){
      echo "<p>Bitte geben Sie einen Vornamen ein!</p>";
      return FALSE;
   }
   if(!isset($secondname)){
      echo "<p>Bitte geben Sie einen Nachnamen ein!</p>";
      return FALSE;
   }
   //Ab hier Konventionen für den Namen!
   
   for ($i = 0; $i < strlen($firstname);)
   {
       if(substr($firstname, $i, 1)!=" "){
            $_SESSION["firstname"]=$firstname;
       }
       $i += 1;
   }
   for ($i = 0; $i < strlen($secondname);)
   {
       if(substr($secondname, $i, 1)!=" "){
            $_SESSION["secondname"]=$secondname;
       }
       $i += 1;
   }
   //Testet, ob ein Zeichen außer Leerzeichen im Namen steht
   if(!isset($_SESSION["firstname"])){
       echo "<p>Dies ist kein Vorname!</p>";
       return FALSE;
   }
  if(!isset($_SESSION["secondname"])){
       echo "<p>Dies ist kein Nachname!</p>";
       return FALSE;
   }
	return TRUE;
}

?>