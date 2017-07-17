<?php


//gibt username zurück
   function getUsername($id){
      
      //$title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$id);
      
      $name = SQLQuery1("SELECT * FROM user WHERE PKID_user = ?", $id);

      return $name['username'];
   }
// prüft ob/wie viele ungelesene nachrichten vorhanden sind
   function checkMessages($id){
      $messages = SQLQuery1("SELECT unread_messages FROM user WHERE PKID_user= ?", $id);
      return $messages['unread_messages'];
   }

//erstellt einen Thread in der Liste
   function createThreadEntry($PKID, $title, $creator){
         
      $username = SQLQuery1("SELECT username FROM user WHERE PKID_user = ?", $creator);
            
      //zeigt Titel, erstellername und Anzahl der Posts an, bei sm und xs titel in eigener Anzeige
      echo '<li class="list-group-item">
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><span class="glyphicon glyphicon-file"></span> <a href="forum.php?p=thread&thread='.$PKID.'&page=1">'.$title.'</a></div>
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2"><span class="glyphicon glyphicon-user"></span> <a href="intern.php?p=profile&uid='.$creator.'">'.$username['username'].'</a></div>
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2"><span class="glyphicon glyphicon-comment"></span> Beitr&auml;ge: '.getPostNumber($PKID).'</div>
         </div>
         </li>';
            
   }

//gibt Anzazhl der Posts im thread zurück
   function getPostNumber($id){
            
      $tempNr = SQLQuery1("SELECT COUNT(PKID_post) as num FROM post WHERE FK_thread = ?", $id);
      return $tempNr['num'];
   }

//erstellt Panel und liste, ruft createThreadEntry auf
//Parameter für jede ansicht angepasst
   function createTopPosts($head, $sqlString){
      global $pdo;
      
       echo '<div class="row"><div class="panel panel-default">
               <div class="panel-heading">
                     '.$head.'
               </div>';
                 
      echo '<ul class="list-group">';

      $i=0;
      foreach ($pdo->query($sqlString) as $row) {
         //holt nötige Informationen zur threadID und  erstellt den Listeneintrag
         $thread = SQLQuery1("SELECT * FROM thread WHERE PKID_thread = ?", $row['FK_thread']);      
         createThreadEntry($thread['PKID_thread'], $thread['theme'], $thread['FK_creator']); 
         //maximal 3 Einträge sollen angezeigt werden
         $i++;
         if($i== 3){
            echo '</ul>
            </div></div>';
            return;
         }
      }
      if($i==0){
         echo '<li class="list-group-item">
                  <span class="glyphicon glyphicon-info-sign"></span> Momentan leider keine TopPosts verf&uuml;gbar.
         </li>';
      }
      
      echo '</ul>
      </div></div>';
   }

   


?>