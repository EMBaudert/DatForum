<?php

/*sucht und gibt alle Ergebnisse an
   sucht im Titel nach Eingabe im Text an beliebiger Stelle
*/
   function createSearchOverview(){
      global $pdo;
      
      echo '<div class="row">
         <div class="panel-group">
            <div class="panel panel-default">
               <ul class="list-group">';
      $statement = $pdo->prepare("SELECT * FROM thread WHERE theme LIKE '%".$_GET['search']."%'");
      $statement->execute();
      $i=0;
      while ($row = $statement->fetch()) {
         if($i>= (($_GET['page']-1)*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
            createSearchPoint($row);
         } 
         $i++;
       
      }
      
      echo '</ul></div></div></div>';
   }
   
   /* erstellt einen einzelnen Men�punkt */
   function createSearchPoint($row){
       $search = stripos($row['theme'],$_GET['search']);
        $strlen = strlen($_GET['search']);
        $final = substr($row['theme'],$search, $strlen);
        
        
         $text = str_replace($final,'<b>'.$final.'</b>',$row['theme']);
         echo '<li class="list-group-item">
            <a href="forum.php?p=thread&thread='.$row['PKID_thread'].'&page=1">'.$text.'</a>
         </li>';
   }

//erstellt "2nd row", inklusive pagination
   function create2ndRow(){
   
      echo '<div class="row marg-tb-5">
         <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <h3>Suchergebnisse f&uuml;r '.$_GET['search'].'</h3>
         </div>
         <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">'; 
            createPagination();
         echo '</div>
            </div>';
               
   }
      
//erstellt pagination
   function createPagination(){
         
   //GETPagenumber
   $pageNumber = SQLQuery1("SELECT COUNT(PKID_thread) as cnt FROM thread WHERE theme LIKE '%?%'", $_GET['search']); 
        
   
    echo '<nav aria-label="pagination">
      <ul class="pagination pull-right">';     
         
      //calculate needed pages
      $pa = ceil($pageNumber['cnt'] / MAX_ENTRY_NUMBER);

      //Previous button, if page 1 is selected button GETs deactivated
      if($_GET['page'] == 1){
                   echo '<li class="disabled"><a href=""><span aria-hidden="true">&laquo;</span></a></li>';
               }else{
                  echo '<li><a href="forum.php?p=search&search='.$_GET['search'].'&page='.($_GET['page']-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
            }
            //if only one page is needed add this one custom
            if($pa == 0){
               echo '<li class="active"><a href="forum.php?psearch&search='.$_GET['search'].'&page=1">1</a></li>';   
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
            
            //last button, if last site is selected buttons GET deactivated
            if($_GET['page'] == ceil($pa) || $pa == 0){
                  echo '<li class="disabled"><span aria-hidden="true">&raquo;</span></li>';
               }else{
                  echo '<li><a href="forum.php?p=search&search='.$_GET['search'].'&page='.($_GET['page']+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
            }
         
         echo '</ul></nav>';
         
      }
//erstellt einzelnun Punkt der Pagination
   function createSingleMenuPoint($nr){
       if($_GET['page']==$nr){
          echo '<li class="active"><a href="forum.php?p=search&search='.$_GET['search'].'&page='.$nr.'">'.$nr.'</a></li>';   
       }else{
          echo '<li><a href="forum.php?p=search&search='.$_GET['search'].'&page='.$nr.'">'.$nr.'</a></li>';   
       }
   }

?>