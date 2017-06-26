<?php

         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');

function getUsername($id){
   
   //$title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$id);
   
   $name = SQLQuery("SELECT * FROM user WHERE PKID_user = ".$id);

   return $name['username'];
}

function checkMessages(){
   
   return 0;
}

function createThreadEntry($PKID, $title, $creator){
      
   $username = SQLQuery("SELECT username FROM user WHERE PKID_user = ".$creator);
         
   echo '<li class="list-group-item">
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><span class="glyphicon glyphicon-comment"></span><a href="thread.php?thread='.$PKID.'&page=1"> '.$title.'</a></div>
         <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="user.php?user='.$creator.'">'.$username['username'].'</a></div>
         <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">Beitr&auml;ge: '.getPostNumber($PKID).'</div>
      </div>
      </li>';
         
}

function getPostNumber($id){
         
   $tempNr = SQLQuery("SELECT COUNT(PKID_post) as num FROM post WHERE FK_thread = ".$id);
   return $tempNr['num'];
}

function createTopPosts($head, $sqlString){
   global $pdo;
    echo '<div class="panel panel-default">
    <div class="panel-heading">
                  '.$head.'
               </div>';
              
   echo '<ul class="list-group">';

   $i=0;
   foreach ($pdo->query($sqlString) as $row) {

      $thread = SQLQuery("SELECT * FROM thread WHERE PKID_thread = ".$row['FK_thread']);      
      createThreadEntry($thread['PKID_thread'], $thread['theme'], $thread['FK_creator']); 
      $i++;
      if($i== 3){
         return;
      }
   }
   
   echo '</ul>
   </div>';
}

function SQLQuery($query){
   global $pdo;
   $temp=$pdo->query($query);
   $temp->execute();
   return $temp->fetch();
            
}


?>