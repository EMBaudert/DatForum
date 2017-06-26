<?php


//gibt username zur�ck
   function getUsername($id){
      
      //$title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$id);
      
      $name = SQLQuery("SELECT * FROM user WHERE PKID_user = ".$id);

      return $name['username'];
   }
// pr�ft ob/wie viele ungelesene nachrichten vorhanden sind
   function checkMessages($id){
      $messages = SQLQuery("SELECT unread_messages FROM user WHERE PKID_user=".$id);
      return $messages['unread_messages'];
   }

//erstellt einen Thread in der Liste
   function createThreadEntry($PKID, $title, $creator){
         
      $username = SQLQuery("SELECT username FROM user WHERE PKID_user = ".$creator);
            
      //zeigt Titel, erstellername und Anzahl der Posts an, bei sm und xs titel in eigener Anzeige
      echo '<li class="list-group-item">
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><span class="glyphicon glyphicon-file"></span> <a href="thread.php?thread='.$PKID.'&page=1">'.$title.'</a></div>
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2"><span class="glyphicon glyphicon-user"></span> <a href="user.php?user='.$creator.'">'.$username['username'].'</a></div>
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2"><span class="glyphicon glyphicon-comment"></span> Beitr&auml;ge: '.getPostNumber($PKID).'</div>
         </div>
         </li>';
            
   }

//gibt Anzazhl der Posts im thread zur�ck
   function getPostNumber($id){
            
      $tempNr = SQLQuery("SELECT COUNT(PKID_post) as num FROM post WHERE FK_thread = ".$id);
      return $tempNr['num'];
   }

//erstellt Panel und liste, ruft createThreadEntry auf
//Parameter f�r jede ansicht angepasst
   function createTopPosts($head, $sqlString){
      global $pdo;
      
       echo '<div class="panel panel-default">
               <div class="panel-heading">
                     '.$head.'
               </div>';
                 
      echo '<ul class="list-group">';

      $i=0;
      foreach ($pdo->query($sqlString) as $row) {
         //holt n�tige Informationen zur threadID und  erstellt den Listeneintrag
         $thread = SQLQuery("SELECT * FROM thread WHERE PKID_thread = ".$row['FK_thread']);      
         createThreadEntry($thread['PKID_thread'], $thread['theme'], $thread['FK_creator']); 
         //maximal 3 Eintr�ge sollen angezeigt werden
         $i++;
         if($i== 3){
            return;
         }
      }
      
      echo '</ul>
      </div>';
   }

   


?>