<?php

#In dieser Datei sind alle Funktionen, die auf den User bezogen sind, also Login, Registrierung und Profilverwaltung
#Das Konstrukt 
#
#<div class="alert alert-danger alert-dismissible" role="alert">
#    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
#    <strong>Error!</strong> The username doesn&apos;t exist.
#</div>
#
#taucht in dieser Datei sehr oft auf. Dies sind alle Fehlermeldungen, die beim Login/Register auftreten k�nnen.
#Das relevante an diesen Texten ist die letzte Zeile, was nach dem <strong> Tag steht.

function checklogin($user,$pass){                              #Der Test, ob der Login korrekt ist
      
	$sql = "SELECT * FROM user WHERE username=?";
	$login=SQLQuery1($sql,$user);
	if(isset($login["password"])&&$pass==$login["password"]){   #Hier w�re der Login erfolgreich
      $_SESSION["PKID"]=$login["PKID_user"];
      $_SESSION["username"]=$user;
		return "1";                                              
	}else{                                                      #Sonst wird ein Error ausgegeben
		if(!isset($login["password"])){                          #Entweder ein falscher Username, da in der DB nichts passendes gefunden wurde
      $error = '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username doesn&apos;t exist.
             </div>';
		}else{                                                   #Oder eben das falsche Passwort
      $_SESSION["username"]=$user;
      $error = '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> You entered the wrong password.
             </div>';
		}
      
		return "0".$error;                                       #Der entsprechende Error wird mit "0"=FALSE zur�ckgegeben zur weiteren Verarbeitung
	}
}

function checkpass(){                                          #Beim Registrieren testen, ob das eingegebene Passwort in Ordnung ist
   $temppass = $_POST["password"];
	if(!isset($temppass)||$temppass==""){                       #Keine Eingabe
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please enter a password.
             </div>';
		return FALSE;
	}
   if($temppass!=$_POST["password2"]){                         #Passw�rter stimmen nicht �berein
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The entered passwords aren&apos;t equal.
             </div>';
      return FALSE;
   }
   if(strlen($temppass)<6){                                    #Passwort zu kurz
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The password should contain at least 6 characters.
             </div>';     
      return FALSE; 
   }
   if(preg_match("/^[a-zA-Z0-9]*$/",$temppass)){               #Es wird eine Warnung ausgegeben, dass das Passwort unsicher sein k�nnte, wenn es nur aus Buchstaben und Zahlen besteht
      echo '<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Warning!</strong> The entered password may not be sure.
             </div>';  
   }
	return TRUE;                                                #Wenn keiner dieser F�lle eintritt, ist das Passwort in Ordnung
}

function checkusername(){                                      #Beim Registrieren den Username checken
   $username=$_POST["username"];
	if(!isset($username)||$username==""){                       #Wenn nichts eingegeben wurde
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please insert a username.
             </div>';
		return FALSE;
	}
   $sql = "SELECT username FROM user WHERE username=?";
	$register=SQLQuery1($sql,$username);
   if(isset($register["username"])){                           #Falls der Username bereits existiert, wird hier etwas in der DB gefunden
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username is already in use.
             </div>';
      return FALSE;
   }
   
   if(!preg_match("/^[a-zA-Z0-9_\-]*$/",$username)){           #Username darf nur aus diesen Zeichen bestehen
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username may only contain letters, numbers and "_" or "-".
             </div>';     
      return FALSE; 
   }
   if(strlen($username)<6||strlen($username)>25){              #Username darf nicht zu kurz oder lang (DB Begrenzung) sein
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The username must have between 6 and 25 characters.
             </div>';     
      return FALSE; 
   }
   
   $_SESSION["username"]=$username;                            #Falls ncihts davon eingetreten ist, ist der username in Ordnung und wird der Session zugewiesen
	return TRUE;
}

function checkdata(){                                          #Schauen, ob die Datenschutzbestimmungen akzeptiert wurden
   if(isset($_POST["readit"])&&$_POST["readit"]=="on"){
      return TRUE;
   }
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please read and accept the terms and conditions.
             </div>';
   return FALSE;
}

function checkemail(){                                         #Pr�fen, ob die eingegebene E-Mail Adresse korrekt ist
	$emailadress=$_POST["email"];
   if(!isset($emailadress)||$emailadress==""){                 #Wenn nichts eingegeben wurde
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please enter an E-Mail adress.
             </div>';
		return FALSE;
	}
   $sql = "SELECT email FROM user WHERE email=?";
	$register=SQLQuery1($sql,$emailadress);
   if((!isset($_SESSION["logged"])||$_SESSION["logged"]==FALSE)&&isset($register["email"])){ #Wenn die E-Mail bereits registriert wurde (nur w�hrend man nicht angemeldet ist)
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The E-Mail is already in use.
             </div>';
      return FALSE;
   }
   
   if (filter_var($emailadress, FILTER_VALIDATE_EMAIL)) {        #Validierungsfunktion
      if(strlen($emailadress)>50){                               #Darf wieder nicht zu lang sein (DB Begrenzung)
         echo '<div class="alert alert-danger alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <strong>Error!</strong> The entered E-Mail adress is to long. Max. 50 chars
                </div>';     
         return FALSE; 
      }
      $_SESSION["email"]=$emailadress;                            #Wenn das korrekt ist, wird die E-Mail akzeptiert
	   return TRUE;
   }
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The entered E-Mail is no E-Mail.
             </div>';
   return FALSE;
   
   
}

function newuser(){                                                  #Beim Registrieren einen neuen User erstellen
	$_SESSION["firstname"]=$_POST["firstname"];	
	$_SESSION["secondname"]=$_POST["secondname"];	
	$_SESSION["username"]=$_POST["username"];	
	$_SESSION["email"]=$_POST["email"];	
	$PASS = hash('sha512',$_POST["password"]);                        #Passwort wird sha512 verschl�sselt abgelegt
	$pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');

	$sql = "INSERT INTO user (username, firstname, secondname, email, password) VALUES ('".$_SESSION["username"]."', '".$_SESSION["firstname"]."','".$_SESSION["secondname"]."','".$_SESSION["email"]."','".$PASS."')";
	$statement = $pdo->prepare($sql);
	$statement->execute();                                            #Neuer User wird angelegt
   $sql = "SELECT PKID_user FROM user WHERE username=?";
	$ID=SQLQuery1($sql,$_SESSION["username"]);
   $_SESSION["PKID"]=$ID["PKID_user"];                               #Die ID des neuen Benutzers der Session zuweisen
}

function checkname(){                                                #Namen mit gewissen Konventionen testen
   $firstname=$_POST["firstname"];
   $secondname=$_POST["secondname"];
   if(!isset($firstname)||$firstname==""){                           #Kein Vorname eingegeben
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> Please enter a first name.
             </div>';
      return FALSE;
   }else if(!preg_match("/^[A-Z][a-zA-Z \-]*$/",$firstname)){        #Name beginnt mit einem Gro�buchstaben und danach Buchstaben/Leer/-
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> You didn\'t enter an accepted fist name.
             </div>';
      return FALSE;      
   }
   if(strlen($firstname)>25){                                        #L�ngenbegrenzung wegen DB
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The first name(s) can\'t contain more than 25 characters.
             </div>';     
      return FALSE; 
   }
   if(!isset($secondname)||$secondname==""){                         #Nachname analog zu Vorname
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
   
   $_SESSION["firstname"]=$firstname;                 #Ist alles korrekt, werden die Namen gespeichert
   $_SESSION["secondname"]=$secondname;
	return TRUE;
}

function checkID($ID){                                #Test, ob eine ID existiert f�r GET �bergaben (Schutz vor Manipulation)
   $sql = "SELECT PKID_user FROM user WHERE PKID_user=?";
	$existID=SQLQuery1($sql,$ID);
   if(!isset($existID["PKID_user"])){
      return FALSE;
   }
   return TRUE;
}

function checkCookieLogin(){                          #Pr�fen, ob der Login gespeichert wurde
   if(isset($_COOKIE["UID"])){                        #Login wird �ber drei Cookies gespeichert. UID=ID des User
       $sql = "SELECT * FROM user WHERE PKID_user=?";
	    $user=SQLQuery1($sql,$_COOKIE["UID"]);
       $passpart=substr($user["password"],0,20);
       if($_COOKIE["username"]==$user["username"]&&$_COOKIE["pspt"]==$passpart){    #Die ersten 20 Zeichen des verschl�sselten Passwortd werden in pspt gespeichert
         $_SESSION["username"]=$_COOKIE["username"];  #username des Benutzers wird unverschl�sselt gesichert
         $_SESSION["logged"]=true;
         $_SESSION["PKID"]=$user["PKID_user"];
       }
       return TRUE;
   }
   return FALSE;
}

function rememberLogin($user,$passpart){                          #Setzen aller Cookies, falls remember login ausgew�hlt wurde
   setcookie("username",$user,time()+(3600*24*100));              #Die Cookies sind 100 Tage g�ltig
   setcookie("UID",$_SESSION["PKID"],time()+(3600*24*100));
   setcookie("pspt",$passpart,time()+(3600*24*100));
}

function forgetLogin(){                                           #L�schen der Cookies (z.B. bei Logout)
   setcookie("username","",time()-3600);
   setcookie("UID","",time()-3600);
   setcookie("pspt","",time()-3600);
}

function checksecquest($number){                                  #Sicherheitsfrage �berpr�fen
   $sql = "SELECT answer FROM security_questions WHERE PKID_question=?";
   $solution=SQLQuery1($sql,$number);                             #Sicherheitsfragen sind in der Datenbank angegeben mit L�sungen
   if(isset($_POST["secQuest"])&&$_POST["secQuest"]==$solution["answer"]){ #�berpr�fung
      return TRUE;
   }
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> The security question was wrong answered.
             </div>';
   return FALSE;
}

function selectsecquest(){                                        #Auswahl der Sicherheitsfrage f�r die Registrierung
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT * FROM security_questions";
   $max=0;
   $question[0]="Failed to load Question!";                       #Fehler Frage 0
   foreach($pdo->query($sql) as $row){                            #Laden der Fragen und pr�fen, wie viele es gibt
      $max=$row["PKID_question"];
      $question[$max]=$row["question"];
   }
   if($max!=0){
     $quest=rand(1,$max);                                         #Zuf�llige Auswahl der Frage
   }else{
      $quest=0;
   }
   
   return $quest."".$question[$quest];                            #Zur�ckgeben der Fragen ID und der Textfrage. Falls keine Fragen existieren, kommt Frage 0
}

function makeSecure($string){                                     #Benutzereingaben f�r Signatur oder Nachrichten skriptsicher machen und eigene Formatierungen umwandeln
   $newString=htmlentities($string);                              #Skriptsicherheit
   $newString=specialCombos("[\*\*]","<b>","</b>",$newString);    #Eigene erstellte Formatierungen
   $newString=specialCombos("[\_\_]","<i>","</i>",$newString);
   $newString=specialCombos("[\~\~]","<s>","</s>",$newString);
   $newString=specialCombos("[\-\-]","<u>","</u>",$newString);
   $newString=str_replace("++","<br>",$newString);
   return $newString;
}

function specialCombosBack($string){                              #Wenn die Signatur wieder ge�ndert wird, m�ssen die eingenen Formatierungen wieder zur�ckgesetzt werden
   $patterns=array("<b>","</b>");
   $string=str_replace($patterns,"**",$string);
   $patterns=array("<i>","</i>");
   $string=str_replace($patterns,"__",$string);
   $patterns=array("<s>","</s>");
   $string=str_replace($patterns,"~~",$string);
   $patterns=array("<u>","</u>");
   $string=str_replace($patterns,"--",$string);
   $string=str_replace("<br>","++",$string);
   return $string;
}

function specialCombos($pattern,$startTo,$endTo,$string){         #Es wird darauf geachtet, dass jeder ge�ffnete Tag auch wieder geschlossen wird
   $temp=0;
   while(preg_match($pattern,$string)){                           #Immer abwechselnd wird der �ffnen und schlie�en Tag verwendet
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
   if($temp){                                                     #Wenn der Tag nicht geschlossen wurde, wird der Endtag nochmals dran geh�ngt
      $string=$string.$endTo;
   }
   return $string;
}

?>