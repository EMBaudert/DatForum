<?PHP
require_once 'prepareSQL.php';
require_once 'message.func.php';
$text="".time();
$temp=0;
if(isset($_GET["uid"])&&($temp=detectNewMessage($_GET["uid"]))){
   $text.= "New Messages!";
   /*if(isset($_GET["p"])&&$_GET["p"]=="message"){
           $me=getMe();
           $other=getOther();
           $text= getMessages($me,$other["username"]);
   }
   
         document.getElementById("scrollable_chat").innerHTML = "'.$text.'" ;*/
   echo '<script>
                  if(document.getElementById("menuMessages")!=null&&parseInt(document.getElementById("menuMessages").innerHTML)!='.$temp.'){    
                     document.getElementById("menuMessages").innerHTML = "<span class="badge">'.$temp.'</span>";
                     }
                  if(0=='.$temp.'){
                     document.getElementById("menuMessages").innerHTML = "";
                  }
                  
         </script>';
}
#echo $text;
?>