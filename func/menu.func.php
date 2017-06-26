<?php

      function create2ndRow($param){
      
      $upperMenuName = SQLQuery("SELECT * FROM menu WHERE PKID_menu = ". $_GET['menu']);
      
        echo '<div class="row marg-tb-5">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
               <h3>'.$upperMenuName['title'].'</h3>   
            </div>
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">';
               if($param && isset($_SESSION['logged']) && $_SESSION['logged'] ==true){
                  echo'<div class="btn-group" role="group">
                              <a href="createPost.php?from=menu&id='.$_GET['menu'].'&creator='.$_SESSION['PKID'].'">
                                 <div type="button" class="btn btn-default">
                                    Neuer Beitrag
                                 </div>
                              </a>
                           </div>';  
               }
            echo '</div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">';
               echo createPagination($param);
            echo '</div>
         </div>';
      }

      function createMenuPoint($title, $count, $nextPoint, $threads){
         global $pdo;
         
         
         if($threads){
            $c = "Threads: ".checkThread($nextPoint);
            $count = $c;
            $ausgabe = "menu=".$nextPoint.'&thread='.$nextPoint.'&page=1';
         }else{
            $ausgabe = "menu=".$nextPoint.'&page=1';
            $count = "Unterpunkte: " . $count; 
        }
         
      
         echo '<li class="list-group-item">
                  <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                     <span class="glyphicon glyphicon-th-list"></span><a href="menu.php?'.$ausgabe.'">  '.$title.'</a>
                     </div>';
         
          echo     '<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">'.$count.'<div>
                  </div>
               </li>';
      } 
      
      function createMenuPointBack(){
        
        $upperMenu = SQLQuery("SELECT FK_menu FROM menu WHERE PKID_menu=".$_GET['menu']);;
         
         if($upperMenu['FK_menu']==NULL){
            $upperMenu['FK_menu']=0;
         }

         echo '<li class="list-group-item">
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9"><span class="glyphicon glyphicon-level-up"></span><a href="menu.php?menu='.$upperMenu['FK_menu'].'&page=1"> ...</a></div>
            </div>
            </li>';
         
         
      }
      
      function createMenu($sqlString) {
         global $pdo;
         
         echo '<div class=\"row\"><ul class=\"hey list-group\">';
         
         if($_GET['menu']!="0"){
            createMenuPointBack();
         }
         
         
         $i=0;
         foreach ($pdo->query($sqlString) as $row) {
         
            if($i>= ($_GET['page']-1*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
             
               $number=SQLQuery("SELECT COUNT(FK_menu) as cnt FROM menu WHERE FK_menu = ".$row['PKID_menu']);
               createMenuPoint($row['title'],$number['cnt'], $row['PKID_menu'], $row['threads']);
            }
            $i++;            
         }
         echo '</ul></div>';
      } 
      
      function checkThread($PKID){
      
         $temp= SQLQuery("SELECT COUNT(PKID_thread) as num FROM thread WHERE FK_menu = ".$PKID);
         return $temp['num'];
      }
      
      function createThreadOverview($id){
         global $pdo;
         
         echo '<div class="row">
         <ul class="list-group">';
         
         createMenuPointBack();
         
         
         $i=0;
;         foreach($pdo->query("SELECT * FROM thread WHERE FK_menu = ".$id) as $row){
         
     //    echo $i;
      //   echo ($_GET['page']-1*MAX_ENTRY_NUMBER);
        // echo ($_GET['page']*MAX_ENTRY_NUMBER);
         
         //if shows
            if($i>= ($_GET['page']-1*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
               createThreadEntry($row['PKID_thread'], $row['theme'], $row['FK_creator']); 
            }
            $i++;
         }
         
         echo '</ul></div>';         
         
      }
      
      function createThreadEntry($PKID, $title, $creator){
      
      
         $username = SQLQuery("SELECT username FROM user WHERE PKID_user = ".$creator);
         
         echo '<li class="list-group-item">
               <div class="row">
               
                  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><span class="glyphicon glyphicon-comment"></span><a href="thread.php?thread='.$PKID.'&page=1"> '.$title.'</a></div>
                  <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="intern.php?p=user&uid='.$creator.'">'.$username['username'].'</a></div>
                  <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">Beitr&auml;ge: '.getPostNumber($PKID).'</div>
               </div>
            </li>';
         
      }
      
      function getPostNumber($id){
         
         $tempNr = SQLQuery("SELECT COUNT(PKID_post) as num FROM post WHERE FK_thread = ".$id);
         return $tempNr['num'];
      }
      
      function createBreadcrumb($id){
         echo '<div class="row"><ol class="breadcrumb">
         <li><a href="menu.php?menu=0&page=1">Main menu</a></li>';
         recursiveBreadCrumb($id,1);
         
         echo '</ol></div>';
         
      }
      
      function recursiveBreadCrumb($id, $first){

         $tempQuery = SQLQuery("SELECT * FROM menu WHERE PKID_menu = ".$id);
         
         if($tempQuery['FK_menu']==NULL){
            echo '<li><a href=\"menu.php?menu='.$tempQuery['PKID_menu'].'&page=1\">'.$tempQuery['title'].'</a></li>';
            return;
         }
         
         recursiveBreadCrumb($tempQuery['FK_menu'],0);
         //If first
         if($first == 0){
            echo '<li><a href=\"menu.php?menu='.$tempQuery['PKID_menu'].'&page=1\">'.$tempQuery['title'].'</a></li>';
         }else{
            echo '<li class=\"active\">'.$tempQuery['title'].'</li>';
         }
         
      }
      
      function SQLQuery($query){
         global $pdo;
         
         $temp=$pdo->query($query);
         $temp->execute();
         return $temp->fetch();
         
      }
      
      function createPagination($thread){
         
         //getPagenumber
         
         if($thread){
            $pageNumber = SQLQuery("SELECT COUNT(PKID_thread) as cnt FROM thread WHERE FK_Menu = ".$_GET['menu']);
         }else{
            if($_GET['menu']==0){
               $pageNumber = SQLQuery("SELECT COUNT(PKID_menu) as cnt FROM menu WHERE FK_menu IS NULL");
            }else{
               $pageNumber = SQLQuery("SELECT COUNT(FK_menu) as cnt FROM menu WHERE FK_menu = ".$_GET['menu']);
            }
         }
    //     echo $pageNumber['cnt'];
         echo '<nav aria-label="pagination">
               <ul class="pagination pull-right">';          
         
            //calculate needed pages
            $pa = $pageNumber['cnt'] / MAX_ENTRY_NUMBER;

            //Previous button, if page 1 is selected button gets deactivated
            if($_GET['page'] == 1){
                  echo '<li class="disabled"><a href=""><span aria-hidden="true">&laquo;</span></a></li>';
               }else{
                  echo '<li><a href="menu.php?menu='.$_GET['menu'].'&page='.($_GET['page']-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
            }
            
            if($pa == 0){
               echo '<li class="active"><a href="menu.php?menu='.$_GET['menu'].'&page=1">1</a></li>';   
            }

            //show all pages
            for($i=1;$i<$pa+1; $i++){
               if($_GET['page']==$i){
                  echo '<li class="active"><a href="menu.php?menu='.$_GET['menu'].'&page='.$i.'">'.$i.'</a></li>';   
               }else{
                  echo '<li><a href="menu.php?menu='.$_GET['menu'].'&page='.$i.'">'.$i.'</a></li>';   
               }
               $maxPages=$i;
            }
            
            if($_GET['page'] ==ceil($pa)|| $pa == 0){
                  echo '<li class="disabled"><a href=""><span aria-hidden="true">&raquo;</span></a></li>';
               }else{
                  
                  echo '<li><a href="menu.php?menu='.$_GET['menu'].'&page='.($_GET['page']+1).'"><span aria-hidden=\"true\">&raquo;</span></a></li>';
            }
         
         echo '</ul></nav>';
         
      }
      
      
   ?>
   