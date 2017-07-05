<?php

function checklogin($user,$pass){
	$pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
	$sql = "SELECT * FROM user WHERE username='".$user."'";
	
	$temppass = $pdo->query($sql);
	$temppass->execute();
	$login=$temppass->fetch();
	if(isset($login["password"])&&$pass==$login["password"]){
      $_SESSION["PKID"]=$login["PKID_user"];
      $_SESSION["username"]=$user;
		return TRUE;
	} 
	else{
		if(!isset($login["password"])){  
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username doesn&apos;t exist.
             </div>';
		}else{
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> You entered the wrong password.
             </div>';
		}
		return FALSE;
	}
}

function checkpass(){
   $temppass = $_POST["password"];
	if(!isset($temppass)||$temppass==""){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please enter a password.
             </div>';
		return FALSE;
	}
   if($temppass!=$_POST["password2"]){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The entered passwords aren&apos;t equal.
             </div>';
      return FALSE;
   }
   #Hier Konventionen für Passwörter
	return TRUE;
}

function checkusername(){
   $username=$_POST["username"];
	if(!isset($username)||$username==""){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please insert a username.
             </div>';
		return FALSE;
	}
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT username FROM user WHERE username='".$username."'";
	$tempuser = $pdo->query($sql);
	$tempuser->execute();
	$register=$tempuser->fetch();
   if(isset($register["username"])){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username is already existing.
             </div>';
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
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username is not okay.
             </div>';
	return FALSE;
}

function checkdata(){
   if(isset($_POST["readit"])&&$_POST["readit"]=="on"){
      return TRUE;
   }
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please read and accept the terms and conditions.
             </div>';
   return FALSE;
}

function checkemail(){
	$emailadress=$_POST["email"];
   if(!isset($emailadress)||$emailadress==""){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please enter an E-Mail adress.
             </div>';
		return FALSE;
	}
   
   if (filter_var($emailadress, FILTER_VALIDATE_EMAIL)) { 
      $_SESSION["email"]=$emailadress;
	   return TRUE;
   }
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The entered E-Mail is no E-Mail.
             </div>';
   return FALSE;
   
   
}

function newuser(){
	$_SESSION["firstname"]=$_POST["firstname"];	
	$_SESSION["secondname"]=$_POST["secondname"];	
	$_SESSION["username"]=$_POST["username"];	
	$_SESSION["email"]=$_POST["email"];	
	$PASS = hash('sha512',$_POST["password"]);
	$pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');

	$sql = "INSERT INTO user (username, firstname, secondname, email, password) VALUES ('".$_SESSION["username"]."', '".$_SESSION["firstname"]."','".$_SESSION["secondname"]."','".$_SESSION["email"]."','".$PASS."')";
	$statement = $pdo->prepare($sql);
	$statement->execute();   
   $sql = "SELECT PKID_user FROM user WHERE username='".$_SESSION["username"]."'";
	$tempID = $pdo->query($sql);
	$tempID->execute();
	$ID=$tempID->fetch();
   $_SESSION["PKID"]=$ID["PKID_user"];
}

function checkname(){
   $firstname=$_POST["firstname"];
   $secondname=$_POST["secondname"];
   if(!isset($firstname)){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please enter a first name.
             </div>';
      return FALSE;
   }
   if(!isset($secondname)){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please enter a second name.
             </div>';
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
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The entered first name wasn&apos;t accepted.
             </div>';
       return FALSE;
   }
  if(!isset($_SESSION["secondname"])){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The entered second name wasn&apos;t accepted.
             </div>';
       return FALSE;
   }
	return TRUE;
}

function checkID($ID){
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT PKID_user FROM user WHERE PKID_user='".$ID."'";
	$tempID = $pdo->query($sql);
	$tempID->execute();
	$existID=$tempID->fetch();
   if(!isset($existID["PKID_user"])){
      return FALSE;
   }
   return TRUE;
}

function checkCookieLogin(){
   if(isset($_COOKIE["UID"])){
       $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
       $sql = "SELECT * FROM user WHERE PKID_user='".$_COOKIE["UID"]."'";
	    $tempuser = $pdo->query($sql);
	    $tempuser->execute();
	    $user=$tempuser->fetch();
       $passpart=substr($user["password"],0,20);
       if($_COOKIE["username"]==$user["username"]&&$_COOKIE["pspt"]==$passpart){
         $_SESSION["username"]=$_COOKIE["username"];
         $_SESSION["logged"]=true;
         $_SESSION["PKID"]=$user["PKID_user"];
       }
       return TRUE;
   }
   return FALSE;
}

function rememberLogin($user,$passpart){
   setcookie("username",$user,time()+(3600*24*100));
   setcookie("UID",$_SESSION["PKID"],time()+(3600*24*100));
   setcookie("pspt",$passpart,time()+(3600*24*100));
}

function forgetLogin(){
   setcookie("username","",time()-3600);
   setcookie("UID","",time()-3600);
   setcookie("pspt","",time()-3600);
}

function checksecquest($number){
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT answer FROM security_questions WHERE PKID_question='".$number."'";
   $tempquest = $pdo->query($sql);
   $tempquest->execute();
   $solution=$tempquest->fetch();
   if(isset($_POST["secQuest"])&&$_POST["secQuest"]==$solution["answer"]){
      return TRUE;
   }
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The security question was wrong answered.
             </div>';
   return FALSE;
}

function selectsecquest(){
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT * FROM security_questions";
   $max=0;
   $question[0]="Failed to load Question!";
   foreach($pdo->query($sql) as $row){
      $max=$row["PKID_question"];
      $question[$max]=$row["question"];
   }
   if($max!=0){
     $quest=rand(1,$max); 
   }else{
      $quest=0;
   }
   
   
   return $quest."".$question[$quest];
}

?>