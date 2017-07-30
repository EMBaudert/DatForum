<?PHP
session_start();
require_once 'prepareSQL.func.php';
require_once 'message.func.php';
   $me=getMe();
   $other=getOther();
   $text= getMessages($me,$other["username"]);
   echo $text;
   echo '<script>
            var objDiv = document.getElementById("scrollable_chat");
            objDiv.scrollTop = objDiv.scrollHeight;
         </script> ';
?>