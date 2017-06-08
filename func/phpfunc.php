<?php

function checklogin($user,$pass){
	$pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
	$sql = "SELECT password FROM user WHERE username=".$user;
	
	$temppass = $pdo->query($sql);
	$temppass->execute();
	$login=$temppass->fetch();
	if(isset($login)&&$pass==$login){
		return TRUE;
	} 
	else{
		return FALSE;
	}
}

?>