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
         $sql = "SELECT username FROM user WHERE PKID_user=?";
      	$user=SQLQuery1($sql,$retVal["PKID"]);
         $retVal["username"]=$user["username"];
         return $retVal;
      }
   }
}

function getChatPartners($user){
   $ret= '';
   $activeChat=-1;
   //$ret=FALSE;
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
         $sql2 = "SELECT username FROM user WHERE PKID_user=?";
	      $partnername=SQLQuery1($sql2,$partner);
         $ret.= '<a class="list-group-item';
         if($partner==$activeChat){
            $ret.= ' active';
         }else{
            $ret.= '" href="intern.php?p=message&cp='.$partner;
         }
         $ret.= '">'.$partnername["username"];
         $ret.= '<span class="badge" id="newMessages'.$partner.'"></span>';
         $ret.= '</a>';
      }
      foreach($unread as $partner => $value){
         if($unread[$partner]!=0){
           $ret.= '<script>document.getElementById("newMessages'.$partner.'").innerHTML = '.$value.'</script>';
         }
      }
   }
   return $ret;
}

function getMessages($me,$you){
   date_default_timezone_set('Europe/Berlin');
   $date = date('Y-m-d', time());
   $text="";
   $sql = "SELECT * FROM user WHERE username=?";
	$meID=SQLQuery1($sql,$me);
   $from=$meID["PKID_user"];
   $newUnreadMessages = $meID["unread_messages"];
   $sql = "SELECT * FROM user WHERE username=?";
	$youID=SQLQuery1($sql,$you);
   $to=$youID["PKID_user"];
   $sql = "SELECT * FROM messages WHERE FK_to='".$to."' AND FK_from='".$from."' OR FK_to='".$from."' AND FK_from='".$to."'";
                        $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
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

function detectNewMessage($user){
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
   $sql = "SELECT unread_messages FROM user WHERE PKID_user=?";
	$unread=SQLQuery1($sql,$user);
   #echo $unread["unread_messages"];
   if($unread["unread_messages"]!=0){
      $sql = "SELECT * FROM messages WHERE FK_to='".$user."' AND unread='1' ORDER BY PKID_message DESC";
      $count[]=0;
      $text="";
   	foreach($pdo->query($sql) as $row){
         if(!isset($count[$row["FK_from"]])){
            $count[$row["FK_from"]]=0;
         }
         $count[$row["FK_from"]]++;
   	}
      $chatPartners = getChatPartners($user);
      echo '<script>if(document.getElementById("chatPartners")!=null){
                     if(document.getElementById("menuMessages").innerHTML!='.$unread["unread_messages"].'){
                        var partners = \''.$chatPartners.'\';
                        document.getElementById("chatPartners").innerHTML = \''.$chatPartners.'\';
                        document.getElementById("menuMessages").innerHTML = "<span class=\"badge\">'.$unread["unread_messages"].'</span>";
                     }
                  }</script>';
     /* foreach($count as $key => $value){
         if($value!=0){
            echo '<script>if(document.getElementById("newMessages'.$key.'")!=null){
                     document.getElementById("newMessages'.$key.'").innerHTML = "'.$value.'";
                     document.getElementById("newMessages'.$key.'").class = "badge";
                  }</script>';
         }else{
            echo '<script>if(document.getElementById("newMessages'.$key.'")!=null){
                     document.getElementById("newMessages'.$key.'").innerHTML = "";
                     document.getElementById("newMessages'.$key.'").class = "";
                  }</script>';
         }
         
      }*/
   }
   return $unread["unread_messages"];   
}

function getLatestMessage($user){
   $sql = "SELECT * FROM messages WHERE FK_to='".$user."' AND unread='1' ORDER BY PKID_message DESC";
   $count=0;
   $text="";
	foreach($pdo->query($sql) as $row){
      if(!isset($partner)){
         $importantMessage=$row;
         $partner = $row["FK_from"];
      }
      if($row["FK_from"]==$partner){
         $count++;
      }
	}
 /*  if(isset($_GET["cp"])&&$_GET["cp"]==$partner){
   
      date_default_timezone_set('Europe/Berlin');
      $date = date('Y-m-d', time());
      $sql = "SELECT * FROM user WHERE PKID_user='".$partner."'";
   	$tempID = $pdo->query($sql);
   	$tempID->execute();
   	$youID=$tempID->fetch();
      $newEntrie= '<li class=\"left clearfix\"><span class=\"chat-img pull-left\">
                             <a href=\"intern.php?p=profile&uid='.$partner.'\"><img src=\"'.$youID["pb_path"].'\" alt=\"User Avatar\" class=\"img-rounded\" style=\"width:50px;\" /></a>
                        </span>
                            <div class=\"chat-body clearfix\">
                                <div class=\"header\">
                                    <a href=\"intern.php?p=profile&uid='.$partner.'\"><strong class=\"primary-font\">'.$youID["username"].'</strong></a> <small class=\"pull-right text-muted\">
                                        <span class=\"glyphicon glyphicon-time\"></span>';
         if($date!=$row["date"]){
            $newEntrie .= $row["date"].' um ';
         }
         $newEntrie .= $row["time"].' Uhr</small>
                                </div>
                                <p>
                                    '.$row["text"].'
                                </p>
                            </div>
                        </li>';
      $text .= '<script>
                  var temptext = document.getElementById("scrollable_chat").innerHTML+"<li class=\"left clearfix\"><span class=\"chat-img pull-left\"> </li>"  ;
                  document.getElementById("scrollable_chat").innerHTML = temptext ;</script>';
   }*/
   $text .= '<script>if(document.getElementById("newMessages'.$partner.'")!=null){
                     document.getElementById("newMessages'.$partner.'").innerHTML = "'.$count.'";
                     document.getElementById("newMessages'.$partner.'").class = "badge";
                  }</script>';
   return $text;
}

function addMessage($from,$to,$text){
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
   date_default_timezone_set('Europe/Berlin');
   $date = date('Y-m-d', time());
   $daytime = date('H:i:s', time());
   $sql = "SELECT PKID_user FROM user WHERE username=?";
	$ID=SQLQuery1($sql,$from);
   $from=$ID["PKID_user"];
   $sql = "SELECT PKID_user,unread_messages FROM user WHERE username=?";
	$ID=SQLQuery1($sql,$to);
   $to=$ID["PKID_user"];
   $text = makeSecure($text);
   
  
   if($from!=$to){
      $sql = "INSERT INTO messages (text,FK_from,FK_to,date,time) VALUES ('".$text."', '".$from."','".$to."', '".$date."','".$daytime."')";
   	$statement = $pdo->prepare($sql);
   	$statement->execute();
      $newUnreadMessages = 1+$ID["unread_messages"];
      $sql = "UPDATE user SET unread_messages='".$newUnreadMessages."' WHERE PKID_user='".$to."'";
      $update = $pdo->prepare($sql);
     	$update->execute();
   }else{
      $sql = "INSERT INTO messages (text,FK_from,FK_to,date,time,unread) VALUES ('".$text."', '".$from."','".$to."', '".$date."','".$daytime."','0')";
   	$statement = $pdo->prepare($sql);
   	$statement->execute();
   }
   

   echo '<meta http-equiv="refresh" content="0; URL=intern.php?p=message&cp='.$to.'" />';
   return TRUE;
}

?>