<?php

   function createReportsOverview(){
      global $pdo;
   
       echo '<div class="row"><ul class="list-group">';
                  
      $i=0;
      foreach ($pdo->query("SELECT * FROM reports WHERE done = 0") as $row) {
         createReport($row);
      }
                  
      echo '</ul></div>';
   }
   
   
   function createReport($post){
      $user = SQLQuery("SELECT * FROM user WHERE PKID_user = ".$post['FK_user']);
      $thread = SQLQuery("SELECT * FROM thread WHERE PKID_thread = ".$post['FK_thread']);
      echo '<li class="list-group-item">
               <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                     <p style="margin: 7px 0px;padding-left: 5px"><b> '.$post['reason'].'</b> von <b>'.$user['username'].'</b> im Thread <b>'.$thread['theme'].'</b></p>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                     <div class="btn-group pull-right" role="group">
                        <a class ="btn btn-default" href="thread.php?thread='.$thread['PKID_thread'].'&post='.$post['FK_post'].'#'.$post['FK_post'].'">Occupy</a>
                        <a class ="btn btn-default" href="">Mark as solved</a>
                     </div>
                  </div>
               </div>           
            </li>';
   }
   



?>