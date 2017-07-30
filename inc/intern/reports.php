
<script type="text/javascript" src="js/reports.js"></script>
<?php

   //Wenn der nutzer angemeldet ist wird siene Berechtigung überprüft
   if(isset($_SESSION['PKID'])){
   
   echo '<script> var userID = '.$_SESSION['PKID'].';</script>';      
   
      //nur moderatoren und administratoren können reports anschauen
      $user = SQLQuery1("SELECT * FROM user WHERE PKID_user= ?", $_SESSION['PKID']);
         if($user['usergroup']== 'admin' || $user['usergroup']== 'moderator' ){
            createReportsOverview();
         }else{
            echo '<h2>Error: Permission denied</h2>';
         }
   }else{
      echo '<h2>Error: You need to be logged in</h2>';
   }
?>
