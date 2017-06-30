<?php

   function createPostOverview(){
      
      echo '<div';
      
      $threadnumber1 = 0;
      $threadnumber2 = 0;
      foreach($pdo->query("SELECT * FROM post WHERE FK_user = ".$_SESSION['PKID']." SORT BY RK_thread") as $row){
         if($i>= ($_GET['page']-1*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
            if($threadnumber2 = 0){
                 
            }else {
               
            }
         }
         $i++;
      }
      
   }




?>