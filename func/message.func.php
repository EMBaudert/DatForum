<?PHP
function getMe(){
   if(isset($_SESSION["logged"])&&$_SESSION["logged"]==1){
      return $_SESSION["username"];
   }
}

function getOther(){
   if(isset($_SESSION["logged"])&&$_SESSION["logged"]==1){
      if(isset($_GET["cp"])){
         $retVal["PKID"]=$_GET["cp"];
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
         $sql = "SELECT username FROM user WHERE PKID_user='".$retVal["PKID"]."'";
      	$tempuser = $pdo->query($sql);
      	$tempuser->execute();
      	$user=$tempuser->fetch();
         $retVal["username"]=$user["username"];
         return $retVal;
      }
   }
}

function getChatPartners($user){
  echo '<div class="list-group">';
   $activeChat=-1;
   if(isset($_GET["cp"])){
      $activeChat=$_GET["cp"];
   }
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT FK_from, FK_to,unread FROM messages WHERE FK_from='".$user."' OR FK_to='".$user."' ORDER BY PKID_message DESC";
	foreach($pdo->query($sql) as $row){
      if($row["FK_from"]==$user){
         $partner=$row["FK_to"];
      }else{
         $partner=$row["FK_from"];
         if(!isset($unread[$partner])){
            $unread[$partner]=0;
         }
         if($row["unread"]==1){
            $unread[$partner]++;
         }
      }
      if(!isset($unread[$partner])){
            $unread[$partner]=0;
      }
      if(!isset($chatpartners[$partner])||$chatpartners[$partner]==0){
         $chatpartners[$partner]=1;
         $sql2 = "SELECT username FROM user WHERE PKID_user='".$partner."'";
         $tempuser = $pdo->query($sql2);
	      $tempuser->execute();
	      $partnername=$tempuser->fetch();
         echo '<a class="list-group-item';
         if($partner==$activeChat){
            echo ' active';
         }else{
            echo '" href="intern.php?p=message&cp='.$partner;
         }
         echo '">'.$partnername["username"];
         if($unread[$partner]!=0){
            echo '<span class="badge" id="newMessages'.$partner.'">'.$unread[$partner].'</span>';
         }
         echo '</a>';
      }
      foreach($unread as $partner => $value){
         if($unread[$partner]!=0){
           echo '<script>document.getElementById("newMessages'.$partner.'").innerHTML = '.$value.'</script>';
         }
      }
   }
   echo '</div>';
}

function getMessages($me,$you){
   date_default_timezone_set('Europe/Berlin');
   $date = date('Y-m-d', time());
   $text="";
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT * FROM user WHERE username='".$me."'";
	$tempID = $pdo->query($sql);
	$tempID->execute();
	$meID=$tempID->fetch();
   $from=$meID["PKID_user"];
   $newUnreadMessages = $meID["unread_messages"];
   $sql = "SELECT * FROM user WHERE username='".$you."'";
	$tempID = $pdo->query($sql);
	$tempID->execute();
	$youID=$tempID->fetch();
   $to=$youID["PKID_user"];
   $sql = "SELECT * FROM messages WHERE FK_to='".$to."' AND FK_from='".$from."' OR FK_to='".$from."' AND FK_from='".$to."'";
   foreach($pdo->query($sql) as $row){
      if($row["FK_from"]==$from){
         $text .= '<li class="right clearfix"><span class="chat-img pull-right">
                            <a href="intern.php?p=profile&uid='.$from.'"><img src="'.$meID["pb_path"].'" alt="User Avatar" class="img-rounded" style="width:50px;" /></a>
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>';
         if($date!=$row["date"]){
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
      }else{
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
         if($row["unread"]==1){#Ungelesene Nachrichten wieder entfernen
            $sql = "UPDATE messages SET unread='0' WHERE PKID_message='".$row["PKID_message"]."'";
            $update = $pdo->prepare($sql);
           	$update->execute();
            $newUnreadMessages--;
            $sql = "UPDATE user SET unread_messages='".$newUnreadMessages."' WHERE PKID_user='".$meID["PKID_user"]."'";
            $update = $pdo->prepare($sql);
           	$update->execute();
            echo '<script>document.getElementById("newMessages'.$to.'").innerHTML = "";
                  document.getElementById("newMessages'.$to.'").class = "";';
            if (--$meID["unread_messages"]==0){
            echo 'document.getElementById("menuMessages").innerHTML = "";
                  document.getElementById("menuMessages").class = "";</script>';
            } else {
            echo 'document.getElementById("menuMessages").innerHTML = '.$meID["unread_messages"].';</script>';
            }
         }
      }
      #echo $row["FK_from"].$row["FK_to"].$row["text"];
   }
   return $text;
}

function addMessage($from,$to,$text){
   date_default_timezone_set('Europe/Berlin');
   $date = date('Y-m-d', time());
   $daytime = date('H:i:s', time());
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT PKID_user FROM user WHERE username='".$from."'";
	$tempID = $pdo->query($sql);
	$tempID->execute();
	$ID=$tempID->fetch();
   $from=$ID["PKID_user"];
   $sql = "SELECT PKID_user,unread_messages FROM user WHERE username='".$to."'";
	$tempID = $pdo->query($sql);
	$tempID->execute();
	$ID=$tempID->fetch();
   $to=$ID["PKID_user"];
   
   $sql = "INSERT INTO messages (text,FK_from,FK_to,date,time) VALUES ('".$text."', '".$from."','".$to."', '".$date."','".$daytime."')";
	$statement = $pdo->prepare($sql);
	$statement->execute();
   
   $newUnreadMessages = 1+$ID["unread_messages"];
   $sql = "UPDATE user SET unread_messages='".$newUnreadMessages."' WHERE PKID_user='".$to."'";
   $update = $pdo->prepare($sql);
  	$update->execute();

   header('Location: '. $_SERVER['PHP_SELF'].'?p=message&cp='.$to);  
   #echo '<meta http-equiv="refresh" content="0; URL=intern.php?p=message&cp='.$to.'" />';
   return TRUE;
}

?>