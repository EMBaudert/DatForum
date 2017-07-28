<?PHP
require_once 'func/message.func.php';
?>
  <link rel="stylesheet" href="layout/chat.css">
  <div id="setTitle" class="hide">Messages</div>
<div class="row">
 <div id="chatPartners" class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-width:130px;">
<?PHP
if(isset($_SESSION["logged"])&&$_SESSION["logged"]=true){
$hasPartners = getChatPartners($_SESSION["PKID"]);
?>
</div>
                     <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9">
                     <?PHP
           $me=getMe();
           $other=getOther();
           if(isset($_POST["newMessage"])){
               $temp=addMessage($me,$other["username"],$_POST["newMessage"]);
           }
           if(isset($other["username"])){
           $text=getMessages($me,$other["username"]);
           
               
          
         ?>
    <div class="row">
             <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Messages with <a style="color:white;" href="intern.php?p=profile&uid=<?PHP echo $_GET["cp"].'">'.$other["username"]; ?></a>
                    
                </div>
                <div class="panel-body" id="scrollable_chat">
                    <ul class="chat">
                    <?PHP echo $text; ?>
                        
                    </ul>
                </div>
                
       <script>
            var objDiv = document.getElementById("scrollable_chat");
            objDiv.scrollTop = objDiv.scrollHeight;
         </script> 
                <div class="panel-footer">
                        <form action="intern.php?p=message&cp=<?PHP echo $other["PKID"]; ?>" method="post">
                    <div class="input-group">
                        <input id="btn-input" type="text" name="newMessage" class="form-control input-sm" placeholder="Type your message here..." autocomplete="off" />
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" type="submit" id="btn-chat">
                                Send</button>
                        </span>
                      
                    </div>
                    <small>**<b>Fett</b>**   --<u>Unterstrichen</u>--   __<i>Italic</i>__   ~~<s>Durchgestrichen</s>~~   ++Zeilenumbruch</small>
                     </form>
                </div>
        </div>
    </div>
    <?PHP
     }else if($hasPartners){
     
         echo '<h1>Please choose a chat!</h1>';
         
     }else{
         echo '<h1>You have no active chats!</h1>';
      }
     
   
}else{
   echo '</div>
         <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9">
         <h1>Please Login!</h1>';
}
     ?>
</div>

   </div>
  

