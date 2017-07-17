<?php
/*
Hier wird zwischen Thread und Menü unterschieden. Menüs haben eine andere Ansicht, deshalb auch die Methodennamen mit Thread und menu
*/

//erstellt Zeile mit titel evtl. button und pagination
      function create2ndRow($param){
      
      $upperMenuName = SQLQuery1("SELECT * FROM menu WHERE PKID_menu = ?", $_GET['menu']);
         /*marg-5-tb nötig für passenden Abstand 
         bei sm und xs bekommt der Titel eine eigene Zeile
         */
        echo '<div class="row marg-tb-5">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
               <h3>'.$upperMenuName['title'].'</h3>   
            </div>
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">';
               if(isset($_SESSION['PKID'])){
               $usergroup = SQLQuery1("SELECT usergroup FROM user WHERE PKID_user = ?", $_SESSION['PKID']);
                  if($param){
                     echo'<div class="btn-group" role="group">
                              <a href="forum.php?p=createThread&type=thread&id='.$_GET['menu'].'&creator='.$_SESSION['PKID'].'">
                              <div type="button" class="btn btn-default">
                                 Neuer Beitrag
                              </div>
                              </a>
                           </div>';  
                  }else if($usergroup['usergroup']=='admin'){
                     echo'<div class="btn-group" role="group">
                              <a href="forum.php?p=createThread&type=menupoint&id='.$_GET['menu'].'&creator='.$_SESSION['PKID'].'">
                              <div type="button" class="btn btn-default">
                                 Neues Unterforum
                              </div>
                              </a>
                           </div>'; 
                  }
               }
            echo '</div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">';
               echo createPagination($param);
            echo '</div>
         </div>';
      }

//erstellt einen Menüpunkt
      function createMenuPoint($title, $count, $nextPoint, $threads){
         global $pdo;
         
         
         if($threads){
            $c = "Threads: ".checkThread($nextPoint);
            $count = $c;
            $ausgabe = "menu=".$nextPoint."&thread=".$nextPoint."&page=1";
         }else{
            $ausgabe = "menu=".$nextPoint."&page=1";
            $count = "Unterpunkte: " . $count; 
        }
         
      
         echo '<li class="list-group-item">
                  <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                     <span class="glyphicon glyphicon-th-list"></span> <a href="forum.php?p=menu&'.$ausgabe.'">'.$title.'</a>
                     </div>';
         
          echo     '<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">'.$count.'<div>
                  </div>
               </li>';
      } 

//erstellt obersten Menüpunkt um ins Overmenu zu navigieren   
      function createMenuPointBack(){
        
        $upperMenu = SQLQuery1("SELECT FK_menu FROM menu WHERE PKID_menu= ?", $_GET['menu']);;
         
         if($upperMenu['FK_menu']==NULL){
            $upperMenu['FK_menu']=0;
         }

         echo '<li class="list-group-item">
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9"><span class="glyphicon glyphicon-level-up"></span><a href="forum.php?p=menu&menu='.$upperMenu['FK_menu'].'&page=1"> ...</a></div>
            </div>
            </li>';
         
         
      }

// erstellt das ganze Menu, ruft createMenuPoint auf
      function createMenu($sqlString,$menu) {
         global $pdo;
         
         echo '<div class="row"><ul class="list-group">';
         
         if($_GET['menu']!="0"){
            createMenuPointBack();
         }
         
         
      if($menu == 0){
         $statement = $pdo->prepare($sqlString);
         $statement->execute();
      }else{
         $statement = $pdo->prepare($sqlString);
         $statement->execute(array('0' => $_GET['menu']));
      }
      $i=0;
      while ($row = $statement->fetch()) {
            
            if($i>= (($_GET['page']-1)*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
             
               $number=SQLQuery1("SELECT COUNT(FK_menu) as cnt FROM menu WHERE FK_menu = ?", $row['PKID_menu']);
               createMenuPoint($row['title'],$number['cnt'], $row['PKID_menu'], $row['threads']);
            }
            $i++;            
         }
         echo '</ul></div>';
      } 

// Gibt zurück wieviele Threads der Menupunkt hat
      function checkThread($PKID){
      
         $temp= SQLQuery1("SELECT COUNT(PKID_thread) as num FROM thread WHERE FK_menu = ?", $PKID);
         return $temp['num'];
      }

//Sind in einem menu keine Munepunkte mehr sondern Threads, werden diese andersa angezeigt
      function createThreadOverview($id){
         global $pdo;
         
         echo '<div class="row">
         <ul class="list-group">';
         
         createMenuPointBack();

         $statement = $pdo->prepare("SELECT * FROM thread WHERE FK_menu = ?");
         $statement->execute(array('0' => $id));
         $i=0;
         while ($row = $statement->fetch()) {
            //if shows
            if($i>= (($_GET['page']-1)*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
               createThreadEntry($row['PKID_thread'], $row['theme'], $row['FK_creator']); 
            }
            $i++;
         }
         
         echo '</ul></div>';         
         
      }

//Erstellt einen Thread
      function createThreadEntry($PKID, $title, $creator){
      
      
         $username = SQLQuery1("SELECT username FROM user WHERE PKID_user = ?", $creator);
         
         echo '<li class="list-group-item">
               <div class="row">
               
                  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><span class="glyphicon glyphicon-file"></span><a href="forum.php?p=thread&thread='.$PKID.'&page=1"> '.$title.'</a></div>
                  <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2"><span class="glyphicon glyphicon-user"></span> <a href="intern.php?p=profile&uid='.$creator.'">'.$username['username'].'</a></div>
                  <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2"><span class="glyphicon glyphicon-comment"></span> Beitr&auml;ge: '.getPostNumber($PKID).'</div>
               </div>
            </li>';
         
      }

// Gibt die Zahl der Posts in einem Thread zurück
      function getPostNumber($id){
         
         $tempNr = SQLQuery1("SELECT COUNT(PKID_post) as num FROM post WHERE FK_thread = ?", $id);
         return $tempNr['num'];
      }

//Erstellt die Breadcrumb navigation
      function createBreadcrumb($id){
         echo '<div class="row"><ol class="breadcrumb">
         <li><a href="forum.php?p=menu&menu=0&page=1">Main menu</a></li>';
         recursiveBreadCrumb($id,1);
         
         echo '</ol></div>';
         
      }

//Erstellt einzelne Breadcrumb punkte
      function recursiveBreadCrumb($id, $first){

         $tempQuery = SQLQuery1("SELECT * FROM menu WHERE PKID_menu = ?", $id);
         
         if($tempQuery['FK_menu']==NULL){
            echo '<li><a href="forum.php?p=menu&menu='.$tempQuery['PKID_menu'].'&page=1">'.$tempQuery['title'].'</a></li>';
            return;
         }
         
         recursiveBreadCrumb($tempQuery['FK_menu'],0);
         //If first
         if($first == 0){
            echo '<li><a href="forum.php?p=menu&menu='.$tempQuery['PKID_menu'].'&page=1">'.$tempQuery['title'].'</a></li>';
         }else{
            echo '<li class="active">'.$tempQuery['title'].'</li>';
         }
         
      }

//Erstellt Pagination
      function createPagination($thread){
         
         //getPagenumber
         
         if($thread){
            $pageNumber = SQLQuery1("SELECT COUNT(PKID_thread) as cnt FROM thread WHERE FK_Menu = ?", $_GET['menu']);
         }else{
            if($_GET['menu']==0){
               $pageNumber = SQLQuery0("SELECT COUNT(PKID_menu) as cnt FROM menu WHERE FK_menu IS NULL");
            }else{
               $pageNumber = SQLQuery1("SELECT COUNT(FK_menu) as cnt FROM menu WHERE FK_menu = ?", $_GET['menu']);
            }
         }
    //     echo $pageNumber['cnt'];
         echo '<nav aria-label="pagination">
               <ul class="pagination pull-right">';          
         
            //calculate needed pages
            $pa = ceil($pageNumber['cnt'] / MAX_ENTRY_NUMBER);

            //Previous button, if page 1 is selected button gets deactivated
            if($_GET['page'] == 1){
                  echo '<li class="disabled\"><a href=""><span aria-hidden="true">&laquo;</span></a></li>';
               }else{
                  echo '<li><a href="forum.php?p=menu&menu='.$_GET['menu'].'&page='.($_GET['page']-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
            }
            //if only one page is needed add this one custom
            if($pa == 0){
               echo '<li class="active"><a href="forum.php?p=menu&menu='.$_GET['menu'].'&page=1">1</a></li>';   
            }

            if($pa > 5){
               createSingleMenuPoint(1);
               
               if($_GET['page'] == 1){
                  createSingleMenuPoint(2);
                  createSingleMenuPoint(3);
                  createSingleMenuPoint(4);  
               }else if ($_GET['page'] == 2){
                  createSingleMenuPoint(2);
                  createSingleMenuPoint(3);
                  createSingleMenuPoint(4);
               }else if($_GET['page'] == $pa-1){
                  createSingleMenuPoint($pa-3);
                  createSingleMenuPoint($pa-2);
                  createSingleMenuPoint($pa-1);
               }else if($_GET['page'] == $pa){
                  createSingleMenuPoint($pa-3);
                  createSingleMenuPoint($pa-2);
                  createSingleMenuPoint($pa-1);
               }else{
                  createSingleMenuPoint($_GET['page']-1);
                  createSingleMenuPoint($_GET['page']);
                  createSingleMenuPoint($_GET['page']+1);
               }
               
               
               /*
               if($_GET['page'] != $pa-1){
                  echo '<li><a href="">...</a></li>';
               }else if($_GET['page']== ($pa-2)){
                  createSingleMenuPoint($pa-2);
                  createSingleMenuPoint($pa-1);
               } */
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
                  echo '<li><a href="forum.php?p=menu&menu='.$_GET['menu'].'&page='.($_GET['page']+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
            }
         
         echo '</ul></nav>';
         
      }

//Erstellt einzelnen Menupunkt 
      function createSingleMenuPoint($nr){
         if($_GET['page']==$nr){
                  echo '<li class="active"><a href="forum.php?p=menu&menu='.$_GET['menu'].'&page='.$nr.'">'.$nr.'</a></li>';   
               }else{
                  echo '<li><a href="forum.php?p=menu&menu='.$_GET['menu'].'&page='.$nr.'">'.$nr.'</a></li>';   
               }
      }

/* gibt die letzte Seite zurück, benötigt wenn menu.php mit page == last parameter aufgerufen wird.
Dies passiert nur wenn ein neuer menüpunkt verfasst wird. Der letzte Beitrag wird aber immer 
auf der letzten Seite dargestellt. 
*/       
   function getLastPage(){
      if($_GET['menu']== 0){
         $pageNumber = SQLQuery0("SELECT COUNT(PKID_menu) as cnt FROM menu WHERE FK_menu IS NULL");
      }else{
         $pageNumber = SQLQuery1("SELECT COUNT(PKID_menu) as cnt FROM menu WHERE FK_menu = ?", $_GET['menu']);
      }
      return ceil($pageNumber['cnt'] / MAX_ENTRY_NUMBER);  
   }  
   ?>