<?php

function checklogin($user,$pass){
      
	$sql = "SELECT * FROM user WHERE username=?";
	$login=SQLQuery1($sql,$user);
	if(isset($login["password"])&&$pass==$login["password"]){
      $_SESSION["PKID"]=$login["PKID_user"];
      $_SESSION["username"]=$user;
		return "1";
	} 
	else{
		if(!isset($login["password"])){  
      $error = '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username doesn&apos;t exist.
             </div>';
		}else{ 
      $_SESSION["username"]=$user;
      $error = '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> You entered the wrong password.
             </div>';
		}
      
		return "0".$error;
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
   if(strlen($temppass)<6){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The password should contain at least 6 characters.
             </div>';     
      return FALSE; 
   }
   if(preg_match("/^[a-zA-Z0-9]*$/",$temppass)){
      echo '<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Warning!</strong> The entered password may not be sure.
             </div>';  
   }
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
   $sql = "SELECT username FROM user WHERE username=?";
	$register=SQLQuery1($sql,$username);
   if(isset($register["username"])){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username is already in use.
             </div>';
      return FALSE;
   }
   
   if(!preg_match("/^[a-zA-Z0-9_\-]*$/",$username)){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username may only contain letters, numbers and "_" or "-".
             </div>';     
      return FALSE; 
   }
   //Ab hier Konventionen für den Benutzernamen!
   if(strlen($username)<6||strlen($username)>25){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username must have between 6 and 25 characters.
             </div>';     
      return FALSE; 
   }
   
   $_SESSION["username"]=$username;
	return TRUE;
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
   $sql = "SELECT email FROM user WHERE email=?";
	$register=SQLQuery1($sql,$emailadress);
   if(isset($register["email"])){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The E-Mail is already in use.
             </div>';
      return FALSE;
   }
   
   if (filter_var($emailadress, FILTER_VALIDATE_EMAIL)) { 
      if(strlen($emailadress)>50){
         echo '<div class="alert alert-danger alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <strong>Error!</strong> The entered E-Mail adress is to long. Max. 50 chars
                </div>';     
         return FALSE; 
      }
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
   $sql = "SELECT PKID_user FROM user WHERE username=?";
	$ID=SQLQuery1($sql,$_SESSION["username"]);
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
   }else if(!preg_match("/^[A-Z][a-zA-Z \-]*$/",$firstname)){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> You didn\'t enter an accepted fist name.
             </div>';
      return FALSE;      
   }
   if(strlen($firstname)>25){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The first name(s) can\'t contain more than 25 characters.
             </div>';     
      return FALSE; 
   }
   if(!isset($secondname)){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please enter a second name.
             </div>';
      return FALSE;
   }else if(!preg_match("/^[a-zA-Z \-]*$/",$secondname)){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> You didn\'t enter an accepted second name.
             </div>';
      return FALSE;      
   }
   if(strlen($firstname)>25){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The second name can\'t contain more than 25 characters.
             </div>';     
      return FALSE; 
   }
   
   $_SESSION["firstname"]=$firstname;
   $_SESSION["secondname"]=$secondname;
	return TRUE;
}

function checkID($ID){
   $sql = "SELECT PKID_user FROM user WHERE PKID_user=?";
	$existID=SQLQuery1($sql,$ID);
   if(!isset($existID["PKID_user"])){
      return FALSE;
   }
   return TRUE;
}

function checkCookieLogin(){
   if(isset($_COOKIE["UID"])){
       $sql = "SELECT * FROM user WHERE PKID_user=?";
	    $user=SQLQuery1($sql,$_COOKIE["UID"]);
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
   $sql = "SELECT answer FROM security_questions WHERE PKID_question=?";
   $solution=SQLQuery1($sql,$number);
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

function makeSecure($string){
   $newString=htmlentities($string);
   $newString=specialCombos("[\*\*]","<b>","</b>",$newString);
   $newString=specialCombos("[\_\_]","<i>","</i>",$newString);
   $newString=specialCombos("[\~\~]","<s>","</s>",$newString);
   $newString=specialCombos("[\-\-]","<u>","</u>",$newString);
   $newString=str_replace("++","<br>",$newString);
   $newString=str_replace("&gt;&gt;","<li>",$newString);
   $newString=str_replace("&lt;&lt;","</li>",$newString);
   return $newString;
}

function specialCombosBack($string){
   $patterns=array("<b>","</b>");
   $string=str_replace($patterns,"**",$string);
   $patterns=array("<i>","</i>");
   $string=str_replace($patterns,"__",$string);
   $patterns=array("<s>","</s>");
   $string=str_replace($patterns,"~~",$string);
   $patterns=array("<u>","</u>");
   $string=str_replace($patterns,"--",$string);
   $string=str_replace("<br>","++",$string);
   $string=str_replace("<li>",">>",$string);
   $string=str_replace("</li>","<<",$string);
   return $string;
}

function specialCombos($pattern,$startTo,$endTo,$string){
   $temp=0;
   while(preg_match($pattern,$string)){
      switch($temp){
         case '0':
            $string = preg_replace($pattern,$startTo,$string,1);
            $temp=1;
            break;
         case '1':
            $string = preg_replace($pattern,$endTo,$string,1);
            $temp=0;
            break;
      }
   }
   if($temp){
      $string=$string.$endTo;
   }
   return $string;
}

?>