<?PHP
require_once 'func/message.func.php';
?>
  <link rel="stylesheet" href="layout/chat.css">
<div class="row">
 <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-width:130px;">
<div class="list-group">
  <a href="#" class="list-group-item active">Cras justo odio</a>
  <a href="#" class="list-group-item"><span class="badge">14</span>Dapibus ac facilisis in</a>
  <a href="#" class="list-group-item"><span class="badge">14</span>Morbi leo risus</a>
  <a href="#" class="list-group-item"><span class="badge">14</span>Porta ac consectetur ac</a>
  <a href="#" class="list-group-item"><span class="badge">14</span>Vestibulum at eros</a>
</div>
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
                <div class="panel-footer">
                        <form action="intern.php?p=message&cp=<?PHP echo $other["PKID"]; ?>" method="post">
                    <div class="input-group">
                        <input id="btn-input" type="text" name="newMessage" class="form-control input-sm" placeholder="Type your message here..." />
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
     
         echo '<h1 readonly>Bitte w&auml;hlen Sie einen Chat aus!</h1>';
     }
     ?>
</div>

   </div>
  
       <script>
            var objDiv = document.getElementById("scrollable_chat");
            objDiv.scrollTop = objDiv.scrollHeight;
         </script> 
<?PHP


#foreach ($pdo->query($sql) as $row)
?>

