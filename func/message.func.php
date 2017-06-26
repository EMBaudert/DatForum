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
/*<a href="#" class="list-group-item active">Cras justo odio</a>
  <a href="#" class="list-group-item"><span class="badge">14</span>Dapibus ac facilisis in</a>
  <a href="#" class="list-group-item"><span class="badge">14</span>Morbi leo risus</a>
  <a href="#" class="list-group-item"><span class="badge">14</span>Porta ac consectetur ac</a>
  <a href="#" class="list-group-item"><span class="badge">14</span>Vestibulum at eros</a>
*/
   $activeChat=-1;
   if(isset($_GET["cp"])){
      $activeChat=$_GET["cp"];
   }
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT FK_from, FK_to FROM messages WHERE FK_from='".$user."' OR FK_to='".$user."' ORDER BY PKID_message DESC";
	foreach($pdo->query($sql) as $row){
      if($row["FK_from"]==$user){
         $partner=$row["FK_to"];
      }else{
         $partner=$row["FK_from"];
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
         echo '">'.$partnername["username"].'</a>';
      }
   }
   echo '</div>';
}

function getMessages($me,$you){
   $text="";
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT * FROM user WHERE username='".$me."'";
	$tempID = $pdo->query($sql);
	$tempID->execute();
	$meID=$tempID->fetch();
   $from=$meID["PKID_user"];
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
                                    <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>now</small>
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
                                        <span class="glyphicon glyphicon-time"></span>now</small>
                                </div>
                                <p>
                                    '.$row["text"].'
                                </p>
                            </div>
                        </li>';
      }
      #echo $row["FK_from"].$row["FK_to"].$row["text"];
   }
   return $text;
}

function addMessage($from,$to,$text){
   
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   $sql = "SELECT PKID_user FROM user WHERE username='".$from."'";
	$tempID = $pdo->query($sql);
	$tempID->execute();
	$ID=$tempID->fetch();
   $from=$ID["PKID_user"];
   $sql = "SELECT PKID_user FROM user WHERE username='".$to."'";
	$tempID = $pdo->query($sql);
	$tempID->execute();
	$ID=$tempID->fetch();
   $to=$ID["PKID_user"];
   
   $sql = "INSERT INTO messages (text,FK_from,FK_to) VALUES ('".$text."', '".$from."','".$to."')";
	$statement = $pdo->prepare($sql);
	$statement->execute();
   
   header('Location: '. $_SERVER['PHP_SELF'].'?p=message&cp='.$to);  
   #echo '<meta http-equiv="refresh" content="0; URL=intern.php?p=message&cp='.$to.'" />';
   return TRUE;
}

?>