<?php

   function create2ndRow(){
      echo '<div class="row marg-tb-5">
         <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <h3>All your posts</h3>
         </div>
         <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">';
        echo ' </div>
         <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">'; 
            //createPagination();
         echo '</div>
            </div>';
   }

   function createPostOverview(){
      global $pdo;
      
      
      $threadnumber = 0;
      
      
      echo '<div class="row">';
      
      
      $statement = $pdo->prepare("SELECT * FROM post WHERE FK_user = ? ORDER BY FK_thread");
         $statement->execute(array('0' => $_SESSION['PKID']));
      $i=-1;
      $nextPost = 0;
      while ($row = $statement->fetch()) {
         $thread = SQLQuery1("SELECT * FROM thread WHERE PKID_thread = ?", $row['FK_thread']);
      
         $text = $row['text'];
      
            if($nextPost == ($_GET['page']-1)*MAX_ENTRY_NUMBER){
               $nextPost++;
               $i++;
               if($i>= (($_GET['page']-1)*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
                  echo  '<div class="panel-group">
                     <div class="panel panel-default">
                       <div role="heading" class="panel-heading">
                         <a data-toggle="collapse" href="#collapse'.$i.'">
                           <h4 class="panel-title"><span class="caret"></span> '.$thread['theme'].'</h4>
                         </a>
                       </div>
                       <div role="complementary" id="collapse'.$i.'" class="panel-collapse collapse">
                         <ul class="list-group">
                           <li class="list-group-item"><a href="forum.php?p=thread&thread='.$row['FK_thread'].'&post='.$row['PKID_post'].'#'.$row['PKID_post'].'">'.$text.'</a></li>';
               }
            } else if($threadnumber != $row['FK_thread']){
               $i++;
               $nextPost++;
               if($i>= (($_GET['page']-1)*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
                  echo '</ul>
                       </div>
                     </div>
                  </div>
                  <div class="panel-group">
                     <div class="panel panel-default">
                       <div role="heading" class="panel-heading">
                         <a data-toggle="collapse" href="#collapse'.$i.'">
                           <h4 class="panel-title"><span class="caret"></span> '.$thread['theme'].'</h4>
                         </a>
                       </div>
                       <div role="complementary" id="collapse'.$i.'" class="panel-collapse collapse">
                         <ul class="list-group">
                           <li class="list-group-item"><a href="forum.php?p=thread&thread='.$row['FK_thread'].'&post='.$row['PKID_post'].'#'.$row['PKID_post'].'">'.$text.'</a></li>';
               }
            }else {
               if($i>= (($_GET['page']-1)*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
                  echo '<li class="list-group-item"><a href="forum.php?p=thread&thread='.$row['FK_thread'].'&post='.$row['PKID_post'].'#'.$row['PKID_post'].'">'.$text.'</a></li>';
               }
            }
            $threadnumber = $row['FK_thread'];
         
      }
      
            echo '</ul></div></div></div>';
      
   }
   
   function cut_str($row){
      if(strlen($row['text']) > 250){
            $text = substr($row['text'],0,250)."...";
            if(strpos($text, '<cite>')!== false & strpos($text, '</cite>') === false){
               $text = $text.'</cite></footer></blockquote>';
            }else if(strpos($text, '<footer>')!== false & strpos($text, '</footer>') === false){
               $text = $text.'</footer></blockquote>';
            }else if(strpos($text, '<blockquote>')!== false & strpos($text, '</blockquote>') === false){
               $text = $text.'</blockquote>';
            }
            if(strpos($text, '<a')!== false & strpos($text, '</a>') === false){
               $text = $text.'</a>';
            }
         }else{
            $text = $row['text'];
         }
      
         return "<p>".$text."</p>";
   }
   
      function createPagination(){
         
   //getPagenumber
   $pageNumber = SQLQuery1("SELECT COUNT(DISTINCT FK_thread) as cnt FROM post WHERE FK_user = ?", $_SESSION['PKID']); 
   
   echo '<nav aria-label="pagination">
      <ul class="pagination pull-right">';          
         
      //calculate needed pages
      $pa = ceil($pageNumber['cnt'] / MAX_ENTRY_NUMBER);

      //Previous button, if page 1 is selected button gets deactivated
      if($_GET['page'] == 1){
                  echo '<li class="disabled"><a href=""><span aria-hidden="true">&laquo;</span></a></li>';
               }else{
                  echo '<li><a href="forum.php?p=post&page='.($_GET['page']-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
            }
            //if only one page is needed add this one custom
            if($pa == 0){
               echo '<li class="active"><a href="forum.php?p=page&page=1">1</a></li>';   
            }

            if($pa > 5){
            
               createSingleMenuPoint(1);
               
               if($_GET['page'] == 1||$_GET['page'] == 2){
                  createSingleMenuPoint(2);
                  createSingleMenuPoint(3);
                  createSingleMenuPoint(4);  
               }else if($_GET['page'] == $pa-1||$_GET['page'] == $pa){
                  createSingleMenuPoint($pa-3);
                  createSingleMenuPoint($pa-2);
                  createSingleMenuPoint($pa-1);
               }else{
                  createSingleMenuPoint($_GET['page']-1);
                  createSingleMenuPoint($_GET['page']);
                  createSingleMenuPoint($_GET['page']+1);
               }
               
               createSingleMenuPoint($pa);
               
            }else{
               //show all pages
               for($i=1;$i<$pa+1; $i++){
                  createSingleMenuPoint($i);
               }
            }
            
            //last button, if last site is selected buttons get deactivated
            if($_GET['page'] == ceil($pa) || $pa == 0){
                  echo '<li class="disabled"><span aria-hidden="true">&raquo;</span></li>';
               }else{
                  echo '<li><a href="forum.php?p=postpage='.($_GET['page']+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
            }
         
         echo '</ul></nav>';
         
      }
      
   function createSingleMenuPoint($nr){
       if($_GET['page']==$nr){
          echo '<li class="active"><a href="forum.php?p=post&page='.$nr.'">'.$nr.'</a></li>';   
       }else{
          echo '<li><a href="forum.php?p=post&page='.$nr.'">'.$nr.'</a></li>';   
       }
   }

?>