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
                            <img src="'.$meID["pb_path"].'" alt="User Avatar" class="img-rounded" style="width:50px;" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>now</small>
                                    <strong class="pull-right primary-font">'.$meID["username"].'</strong>
                                </div>
                                <p>
                                    '.$row["text"].'
                                </p>
                            </div>
                        </li>';
      }else{
         $text .= '<li class="left clearfix"><span class="chat-img pull-left">
                            <img src="'.$youID["pb_path"].'" alt="User Avatar" class="img-rounded" style="width:50px;" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                   <strong class="primary-font">'.$youID["username"].'</strong> <small class="pull-right text-muted">
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
   
   echo '<meta http-equiv="refresh" content="0; URL=intern.php?p=message&cp='.$to.'" />';
   return TRUE;
}

?>