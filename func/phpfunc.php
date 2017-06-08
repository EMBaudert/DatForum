<?php

function checklogin($user,$pass){
	$pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
	$sql = "SELECT password FROM user WHERE username='".$user."'";
	
	$temppass = $pdo->query($sql);
	$temppass->execute();
	$login=$temppass->fetch();
	if(isset($login["password"])&&$pass==$login["password"]){
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
	if($_POST["password"]==""){
		return FALSE;
	}
	return TRUE;
}

function checkusername(){
	if($_POST["username"]==""){
		return FALSE;
	}
	return TRUE;
}

function checkemail(){
	if($_POST["email"]==""){
		return FALSE;
	}
	return TRUE;
}

function newuser(){
	$_SESSION["firstname"]=$_POST["firstname"];	
	$_SESSION["secondname"]=$_POST["secondname"];	
	$_SESSION["username"]=$_POST["username"];	
	$_SESSION["email"]=$_POST["email"];	
	$PASS = hash('sha512',$_POST["password"]);
	$IDENT=5;
	$pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
 
	$sql = "INSERT INTO user (PKID_user,username, firstname, secondname, email, password) VALUES ('".$IDENT."','".$_SESSION["username"]."', '".$_SESSION["firstname"]."','".$_SESSION["secondname"]."','".$_SESSION["email"]."','".$PASS."')";
	$statement = $pdo->prepare($sql);
	$statement->execute();   
}

?>