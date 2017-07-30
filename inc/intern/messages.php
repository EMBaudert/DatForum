<?PHP

#Über das Nachrichtensystem bekommt der Benutzer die Möglichkeit, mit anderen Nutzern oder Moderatoren private Nachrichten auszutauschen

require_once 'func/message.func.php';
?>
  <link rel="stylesheet" href="layout/chat.css">
  <div id="setTitle" class="hide">Messages</div>
<div class="row">
 <div class="col-xs-5 col-sm-4 col-md-3 col-lg-3" style="min-width:130px;">
<?PHP
if(isset($_SESSION["logged"])&&$_SESSION["logged"]=true){      #Man muss angemeldet sein, um das Nachrichtensystem nutzen zu können
   echo '<div class="list-group" id="chatPartners">';          #Hier stehen die Reiter für die Chatpartner. DIese werden in Echtzeit aktualisiert
   $hasPartners = getChatPartners($_SESSION["PKID"]);
   echo $hasPartners;
   echo '</div>';
   ?>
   <!--
      Die folgende Funktion ist für die Aktualisierung zuständig. Zu Beginn wird gesagt, wo die Ausgabe von den
      aufgerufenen Funktionen landen soll und danach, welche Datei wie aufgerufen wird.
      Mit setInterval wir definiert, in welchem Rhythmus die Datei aufgerufen werden soll
      #ChatPartners sind die linken Reiter
      #activeChat ist der aktive Chat (Thanks Captain Obvious)
   -->
  <script type="text/javascript">
      $(document).ready(function(){
         $('#chatPartners').load("func/liveChatPartners.func.php?uid=<?PHP if(isset($_SESSION["PKID"])) {echo $_SESSION["PKID"];} if(isset($_GET["p"])){echo '&p='.$_GET["p"];} if(isset($_GET["cp"])){echo '&cp='.$_GET["cp"];} ?>");
         $('#activeChat').load("func/refresh.func.php?uid=<?PHP if(isset($_SESSION["PKID"])) {echo $_SESSION["PKID"];} if(isset($_GET["p"])){echo '&p='.$_GET["p"];} if(isset($_GET["cp"])){echo '&cp='.$_GET["cp"];} ?>");
         var refreshId = setInterval(function(){
            $('#chatPartners').load("func/liveChatPartners.func.php?uid=<?PHP if(isset($_SESSION["PKID"])) {echo $_SESSION["PKID"];} if(isset($_GET["p"])){echo '&p='.$_GET["p"];} if(isset($_GET["cp"])){echo '&cp='.$_GET["cp"];} ?>");
         }, 1000);
         var refreshId2 = setInterval(function(){
            $('#activeChat').load("func/refresh.func.php?uid=<?PHP if(isset($_SESSION["PKID"])) {echo $_SESSION["PKID"];} if(isset($_GET["p"])){echo '&p='.$_GET["p"];} if(isset($_GET["cp"])){echo '&cp='.$_GET["cp"];} ?>");
         }, 1000);
      });
   </script>
  </div>
   <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9">
   <?PHP
      $me=getMe();
      $other=getOther();
      if(isset($_POST["newMessage"])){        #Falls eine Nachricht gesendet wurde, wird sie hier versendet
          $temp=addMessage($me,$other["username"],$_POST["newMessage"]);
      }
      if(isset($other["username"])){          #Wenn ein aktiver Chat gewählt ist, wird dieser jetzt geladen
            $text=getMessages($me,$other["username"]);  
            #Ab hier wird der Chat aufgebaut:        
          ?>
          <div class="row">
                   <div class="panel panel-primary">
                      <div class="panel-heading">
                          <span class="glyphicon glyphicon-comment"></span> Messages with <a style="color:white;" href="intern.php?p=profile&uid=<?PHP echo $_GET["cp"].'">'.$other["username"]; ?></a>
                      </div>
                      <div class="panel-body" id="scrollable_chat">
                          <ul class="chat" id="activeChat">
                              <?PHP 
                                  echo $text;              #Und hier werden die Nachrichten ausgegeben  
                              ?> 
                          </ul>
                      </div>
             <!-- Damit der Chat immer unten bei den neuesten Nachrichten steht: -->         
             <script>
                  var objDiv = document.getElementById("scrollable_chat");
                  objDiv.scrollTop = objDiv.scrollHeight;
               </script> 
                      <div class="panel-footer">
             <!-- Eingabefeld für neue Nachrichten -->
                              <form action="intern.php?p=message&cp=<?PHP echo $other["PKID"]; ?>" method="post">
                          <div class="input-group">
                              <input id="btn-input" type="text" name="newMessage" class="form-control input-sm" placeholder="Type your message here..." autocomplete="off" />
                              <span class="input-group-btn">
                                  <button class="btn btn-warning btn-sm" type="submit" id="btn-chat">
                                      Send</button>
                              </span>
                            
                          </div>
              <!-- Informationen zu den eigenen Formatierungszeichen -->
                          <small>**<b>Fett</b>**   --<u>Unterstrichen</u>--   __<i>Italic</i>__   ~~<s>Durchgestrichen</s>~~   ++Zeilenumbruch</small>
                           </form>
                      </div>
              </div>
          </div>
          <?PHP
      }else if($hasPartners){                 #Wenn es Chats gibt, aber keiner ausgewählt ist     
          echo '<h1>Please choose a chat!</h1>';         
      }else{                                  #Wenn es keine Chats gibt
          echo '<h1>You have no active chats!</h1>';
      }   
}else{                                        #Wenn man nicht angemeldet ist                              
   echo '</div>
         <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9">
         <h1>Please Login!</h1>';
}
     ?>
</div>

   </div>
  

