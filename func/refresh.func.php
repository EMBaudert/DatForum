<?PHP

#Diese Datei aktualisiert den aktuellen Chat in echtzeit, sodass neue Nachrichten direkt hinzugefügt werden

session_start();
require_once 'prepareSQL.func.php';
require_once 'message.func.php';
$me=getMe();                                    #Eigenen Username bekommen
$other=getOther();                              #Daten des Chatpartners bekommen
$text= getMessages($me,$other["username"]);     #Die Nachrichten zwischen den beiden Chatpartnern bekommen
echo $text;                                     #Und ausgeben
echo '<script>
         var objDiv = document.getElementById("scrollable_chat");
         objDiv.scrollTop = objDiv.scrollHeight;
      </script> ';                              #Scrollposition des Chats nach ganz unten setzen
?>