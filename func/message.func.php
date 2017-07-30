<?PHP

#In diesem Dokument befinden sich alle Funktionen, die im Nachrichtensystem genutzt werden

function getMe(){ #Funktion gibt den username des aktuellen Benutzers zur|ck (gespeichert in der Session-Variable)
   if(isset($_SESSION["logged"])&&$_SESSION["logged"]==1){
      return $_SESSION["username"];
   }
}

function getOther(){ #Funktion gibt den username und die ID des ausgewdhlten Chatpartners zur|ck
   if(isset($_SESSION["logged"])&&$_SESSION["logged"]==1){  #"logged" sagt, ob der Benutzer angemeldet ist oder nicht
      if(isset($_GET["cp"])){                               #In der Get-Variable "cp" ist die ID des chatpartners enthalten
         $retVal["PKID"]=$_GET["cp"];
         $sql = "SELECT username FROM user WHERE PKID_user=?";
      	$user=SQLQuery1($sql,$retVal["PKID"]);
         $retVal["username"]=$user["username"];
         return $retVal;
      }
   }
}

function getChatPartners($user){ #Funktion erstellt den Code f|r die Chatpartner auf der linken Seite im Nachrichten System
   $ret= '';
   $activeChat=-1;
   if(isset($_GET["cp"])){    #Wenn ein Chat ausgewdhlt ist, wird dieser als aktiv gespeichert
      $activeChat=$_GET["cp"];
   }
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT FK_from, FK_to,unread FROM messages WHERE FK_from='".$user."' OR FK_to='".$user."' ORDER BY PKID_message DESC";   #Laden aller Nachrichten von und an den aktiven Nutzer (neueste zuerst)
	foreach($pdo->query($sql) as $row){    #Wird f|r jede Nachricht ausgef|hrt  
      if($row["FK_from"]==$user){         #Ermittle den Chatpartner dieser Nachricht
         $partner=$row["FK_to"];
      }else{
         $partner=$row["FK_from"];
         if(!isset($unread[$partner])){   #Wenn es eine ungelesene Nachricht ist, wird dies gespeichert
            $unread[$partner]=0;          #Sollte die Variable noch nicht gesetzt sein, wird sie mit 0 initialisiert
         }
         if($row["unread"]==1){           #Und dann f|r jede ungelesene Nachricht von diesem Chatpartner inkrementiert
            $unread[$partner]++;
         }
      }
      if(!isset($unread[$partner])){      #Auch au_erhalb der If muss sichergestellt sein, dass die Variable existiert
            $unread[$partner]=0;
      }
      if(!isset($chatpartners[$partner])||$chatpartners[$partner]==0){  #Wenn f|re diesen Chatpartner noch kein Reiter erstellt wurde, wird er jetzt erstellt (neueste ganz oben)
         $chatpartners[$partner]=1;
         $sql2 = "SELECT username FROM user WHERE PKID_user=?";         #F|r den Reiter wird der username des Chatpartners benvtigt
	      $partnername=SQLQuery1($sql2,$partner);
         $ret.= '<a class="list-group-item';                            #Ab hier wird der Code erzeugt
         if($partner==$activeChat){                                     #Sollte dies der momentan aktive Chat sein, bekommt er die Klasse acive
            $ret.= ' active';
         }else{
            $ret.= '" href="intern.php?p=message&cp='.$partner;         #Falls nicht, wir der Chat mit diesem Partner auf dem Reiter verlinkt
         }
         $ret.= '">'.$partnername["username"];
         $ret.= '<span class="badge" id="newMessages'.$partner.'"></span>';   #Falls dieser Chat neue Nachrichten hat, wird dieser Teil benvtigt
         $ret.= '</a>';
      }
      $allunread=0;                                #Hier werden die neuen Nachrichten verwaltet, in dieser Variable werden alle aufsummiert f|r die neuen Nachrichten in der Navigationsleiste
      foreach($unread as $partner => $value){      #Jedem Chat wird die Anzahl an neuen Nachrichten zugewiesen
         if($unread[$partner]!=0){                 #Wenn es neue Nachrichten in diesem Chat gibt
            $allunread+=$unread[$partner];         #Werden diese aufsummiert und die Anzahl in dem Reiter angezeigt
            $ret.= '<script>document.getElementById("newMessages'.$partner.'").innerHTML = '.$value.'</script>';
         }
      }
      $ret.= '<script>
                  if(document.getElementById("menuMessages")!=null&&parseInt(document.getElementById("menuMessages").innerHTML)!='.$allunread.'){    
                     if(0=='.$allunread.'){
                        document.getElementById("menuMessages").innerHTML = "";
                     }else{
                        document.getElementById("menuMessages").innerHTML = "<span class=\"badge\">'.$allunread.'</span>";
                     }
                  }                  
         </script>'; #Aktualisiert die Nachrichten in der Navigationsleiste, wenn nvtig
   }
   return $ret;      #gibt den erzeugten Code zur|ck
}

function getMessages($me,$you){                    #Diese Funktion gibt den Code f|r die Chatnachrichten zur|ck
   date_default_timezone_set('Europe/Berlin');
   $date = date('Y-m-d', time());                  #Wenn die Nachricht von heute ist, wird nur die Uhrzeit angezeigt, sonst auch das Datum
   $text="";
   $sql = "SELECT * FROM user WHERE username=?";
	$meID=SQLQuery1($sql,$me);
   $from=$meID["PKID_user"];                       #Die Daten vom aktuellen Benutzer holen
   $newUnreadMessages = $meID["unread_messages"];  #Um spdter die ungelesenen Nachrichten zu aktualisieren wird dieser Wert benvtigt
   $sql = "SELECT * FROM user WHERE username=?";
	$youID=SQLQuery1($sql,$you);
   $to=$youID["PKID_user"];                        #Die Daten vom Chatpartner holen
   $sql = "SELECT * FROM messages WHERE FK_to='".$to."' AND FK_from='".$from."' OR FK_to='".$from."' AND FK_from='".$to."'";
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
   foreach($pdo->query($sql) as $row){             #F|r jede Nachricht zwischen den beiden wird Code f|r eine Nachricht erzeugt
      if($row["FK_from"]==$from){                  #Wenn die Nachricht vom angemeldeten Nutzer ist wird die Nachricht rechtsb|ndig
         $text .= '<li class="right clearfix"><span class="chat-img pull-right">
                            <a href="intern.php?p=profile&uid='.$from.'"><img src="'.$meID["pb_path"].'" alt="User Avatar" class="img-rounded" style="width:50px;" /></a>
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>';
         if($date!=$row["date"]){                  #Auf heutiges Datum pr|fen
            $text .= $row["date"].' um ';
         }
         $text .= $row["time"].' Uhr</small>
                                     <a href="intern.php?p=profile&uid='.$from.'"><strong class="pull-right primary-font">'.$meID["username"].'</strong></a>
                                </div>
                                <p>
                                    '.$row["text"].'
                                </p>
                            </div>
                        </li>';
      }else{                                       #Wenn die Nachricht vom Chatpartner ist, wird sie linksb|ndig
         $text .= '<li class="left clearfix"><span class="chat-img pull-left">
                             <a href="intern.php?p=profile&uid='.$to.'"><img src="'.$youID["pb_path"].'" alt="User Avatar" class="img-rounded" style="width:50px;" /></a>
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <a href="intern.php?p=profile&uid='.$to.'"><strong class="primary-font">'.$youID["username"].'</strong></a> <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span>';
         if($date!=$row["date"]){
            $text .= $row["date"].' um ';
         }
         $text .= $row["time"].' Uhr</small>
                                </div>
                                <p>
                                    '.$row["text"].'
                                </p>
                            </div>
                        </li>';
         if($row["unread"]==1){                                                                    #Ungelesene Nachrichten wieder entfernen
            $sql = "UPDATE messages SET unread='0' WHERE PKID_message='".$row["PKID_message"]."'";
            $update = $pdo->prepare($sql);
           	$update->execute();
            $newUnreadMessages--;                                                                  #Ungelesene Nachrichten des Benutzers dekrementieren
            $sql = "UPDATE user SET unread_messages='".$newUnreadMessages."' WHERE PKID_user='".$meID["PKID_user"]."'"; #Und den neuen Wert speichern
            $update = $pdo->prepare($sql);
           	$update->execute();
            echo '<script>document.getElementById("newMessages'.$to.'").innerHTML = "";
                  document.getElementById("newMessages'.$to.'").class = "";'; #Etwas Javascript um die Chatpartner Reiter und die Navigationsleiste zu aktualisieren
            if (--$meID["unread_messages"]==0){                               #Wenn der Benutzer keine ungelesenen Nachrichten mehr hat, wird das Symbol aus der Navigationsleiste entfernt
            echo 'document.getElementById("menuMessages").innerHTML = "";</script>';
            } else {
            echo 'document.getElementById("menuMessages").innerHTML = "<span class=\"badge\">'.$meID["unread_messages"].'</span>";</script>';
            }
         }
      }
   }
   return $text;
}

function addMessage($from,$to,$text){                                   #Mit dieser Funktion wird eine neue Nachricht versendet
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
   date_default_timezone_set('Europe/Berlin');
   $date = date('Y-m-d', time());                                       #Die Absendezeit
   $daytime = date('H:i:s', time());
   $sql = "SELECT PKID_user FROM user WHERE username=?";
	$ID=SQLQuery1($sql,$from);
   $from=$ID["PKID_user"];                                              #Die benvtigten IDs holen
   $newUnreadMessages=$ID["unread_messages"];
   $sql = "SELECT PKID_user,unread_messages FROM user WHERE username=?";
	$ID=SQLQuery1($sql,$to);
   $to=$ID["PKID_user"];
   $text = makeSecure($text);                                           #Der eingegebene Text wird sicher gemacht und eigene Formatierungen angewand (->user.func.php)
   
   if($from!=$to){                                                      #Sollte eine Nachricht an sich selbst gesendet werden, muss diese nicht als ungelesen abgestempelt werden
      $sql = "INSERT INTO messages (text,FK_from,FK_to,date,time) VALUES ('".$text."', '".$from."','".$to."', '".$date."','".$daytime."')";  #Neue Nachricht einf|gen
   	$statement = $pdo->prepare($sql);
   	$statement->execute();
      $newUnreadMessages++;
      $sql = "UPDATE user SET unread_messages='".$newUnreadMessages."' WHERE PKID_user='".$to."'"; #Ungelesene Nachrichten aktualisieren
      $update = $pdo->prepare($sql);
     	$update->execute();
   }else{                                                               #Wie oben nur ohne ungelesene Nachrichten aktualisieren
      $sql = "INSERT INTO messages (text,FK_from,FK_to,date,time,unread) VALUES ('".$text."', '".$from."','".$to."', '".$date."','".$daytime."','0')";
   	$statement = $pdo->prepare($sql);
   	$statement->execute();
   }
   echo '<meta http-equiv="refresh" content="0; URL=intern.php?p=message&cp='.$to.'" />'; #Seite neu laden, damit die gesendeten Daten aus dem Cache verschwinden
   return TRUE;
}

?>