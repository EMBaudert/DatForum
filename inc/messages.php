<?PHP
require_once 'func/message.func.php';
?>
  <link rel="stylesheet" href="layout/chat.css">
  <title>DatForum &ndash; Messages</title>
<div class="row">
 <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-width:130px;">
<?PHP
getChatPartners($_SESSION["PKID"]);
?>
</div>
                     <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9">
                     <?PHP
           $me=getMe();
           $other=getOther();
           if(isset($_POST["newMessage"])){
               $temp=addMessage($me,$other["username"],$_POST["newMessage"]);
           }
           $text=getMessages($me,$other["username"]);
           if(isset($other["username"])){
               
          
         ?>
    <div class="row">
             <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Messages with <?PHP echo $other["username"]; ?>
                    
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
                     </form>
                </div>
        </div>
    </div>
    <?PHP
     }else{
     
         echo '<h1 readonly>Please choose a chat!</h1>';
         
     }
     ?>
</div>

   </div>
  
<?PHP


#foreach ($pdo->query($sql) as $row)
?>

