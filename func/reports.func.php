
<?php

//erstellt den reportsoverview
   function createReportsOverview(){
      global $pdo;
   
       echo '<div class="row"><ul class="list-group">';
                  
      $i=0;
      foreach ($pdo->query("SELECT * FROM reports WHERE done = 0") as $row) {
         createReport($row);
      }
                  
      echo '</ul></div>';
   }
   
   
//   erstellt einen eintrag in der Liste 
   function createReport($post){
      $user = SQLQuery1("SELECT * FROM user WHERE PKID_user = ?", $post['FK_user']);
      $thread = SQLQuery1("SELECT * FROM thread WHERE PKID_thread = ?", $post['FK_thread']);
      echo '<li class="list-group-item">
               <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                     <p style="margin: 7px 0px;padding-left: 5px"><b>Begr&uuml;ndung: </b>'.$post['reason'].' <b>Post von: </b>'.$user['username'].'<b> Im Thread: </b>'.$thread['theme'].'</p>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                     <div class="btn-group pull-right" role="group">
                        <a class ="btn btn-default" href="forum.php?p=thread&thread='.$thread['PKID_thread'].'&post='.$post['FK_post'].'#'.$post['FK_post'].'">Occupy</a>
                        <a class ="btn btn-default solved" id="'.$post['PKID_report'].'">Mark as solved</a>
                     </div>
                  </div>
               </div>           
            </li>';
   }
   
  


?>