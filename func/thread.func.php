<?php

//
   function createPostOverview(){
      global $pdo;
            
      if(isset($_GET['post'])){
         $pageNumber = SQLQuery("SELECT COUNT(PKID_post) as cnt FROM post WHERE FK_thread = ".$_GET['thread']); 
         $postNumber = SQLQuery("SELECT COUNT(PKID_post) as cnt FROM post WHERE FK_thread = ".$_GET['thread']." AND PKID_post < ".$_GET['post']); 
         //calculate correct page
         $_GET['page'] = ceil(($postNumber['cnt']/ MAX_ENTRY_NUMBER)+0.00001);
      }
      echo '<div class="row"><ul class="list-group">';
                  
      $i=0;
      foreach ($pdo->query("SELECT * FROM post WHERE FK_thread = ".$_GET['thread']) as $row) {
                  
         if($i>= (($_GET['page']-1)*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
                      
            createPost($row);
         }
         $i++;            
      }
                  
      echo '</ul></div>';
   }    
      
   function createPost($post){
         
      $user = SQLQuery("SELECT * FROM user WHERE PKID_user = ".$post['FK_user']);
      $title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$post['FK_thread']);

 		//<hr class="colorline">                  <div class='.row"></div>
      echo '<div class="panel panel-primary" id="'.$post['PKID_post'].'">
         <div class="panel-heading">
            '.$post['date'].' '.$post['time'].'
         </div>
            			
         <div class="row equal">
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 post-userinfo ">
               <div class="hidden-xs hidden-sm nospace">
                  <p><a href="intern.php?p=profile&uid='.$post['FK_user'].'">'.$user['username'].'</a><br>' 
                     .$user['usergroup'].
                  '</p>
                  <img src="'.$user['pb_path'].'" class="profile-picture">
               </div>
               <div class="hidden-md hidden-lg nospace">
                  <div class="col-xs-6 nospace">
                     <p><a href="intern.php?p=profile&uid='.$post['FK_user'].'">'.$user['username'].'</a><br>'
                  	  .$user['usergroup'].
                     '</p>
                  </div>
                  <div class="col-xs-6 ">
                     <img src="'.$user['pb_path'].'" class="profile-picture">
                  </div>
               </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 post-content minheight">
               <p><b>'.$title['theme'].'</b></p>
               <hr class="hr-postcontent">
               <p class="content minheight">'.$post['text'].'</p>

               <div class="min-height-f">
                  <hr class="hr-postcontent">
                  <p>'.$user['signature'].'</p>
               </diV>
            </div>
         </div>
            			
         <div class="panel-footer ">
            <div class="row">
               <div class="btn-group pull-right" role="group">';
						   
					 if(isset($_SESSION["PKID"])){
                  $usergroup = SQLQuery("SELECT * FROM user WHERE PKID_user =".$_SESSION['PKID']);
					    if($user['PKID_user'] == $_SESSION["PKID"]){
                     echo  '<a class ="btn btn-default" href="createPost.php?type=edit&id='.$post['PKID_post'].'"><span class="glyphicon glyphicon-edit"></span> Edit</a>';	
                   }
                   if($usergroup['usergroup']=='admin' || $usergroup['usergroup']== 'moderator'){
                     echo '<a class ="btn btn-default" href=""><span class="glyphicon glyphicon-edit"></span> L&ouml;schen</a>';
                   }else {
                     echo  '<a class ="btn btn-default" id="report"><span class="glyphicon glyphicon-edit"></span> Melden</a>';
                   }
               }
					    echo '<a class ="btn btn-default" href="createPost.php?type=quote&id='.$_GET['thread'].'&quoteid='.$post['PKID_post'].'"><span class="glyphicon glyphicon-bullhorn"></span> Zitieren</a>
               </div>
            </div>
         </div>
         </div>';

         }

   function create2ndRow(){
      global $pdo;
         
      $title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$_GET['thread']);
         
      echo '<div class="row marg-tb-5">
         <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <h3>'.$title['theme'].'</h3>
         </div>
         <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">';
         if(isset($_SESSION['logged'])){
           echo '<div class="btn-group" role="group">
               <a href="createPost.php?id='.$_GET['thread'].'&creator='.$_SESSION['PKID'].'">
               <div type="button" class="btn btn-default">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Neuer Beitrag
               </div>
               </a>
            </div>';
            }
        echo ' </div>
         <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">'; 
            createPagination();
         echo '</div>
            </div>';
               
   }
      
   function createPagination(){
         
   //getPagenumber
   $pageNumber = SQLQuery("SELECT COUNT(PKID_post) as cnt FROM post WHERE FK_thread = ".$_GET['thread']); 
        
   
   echo "<nav aria-label=\"pagination\">
      <ul class=\"pagination pull-right\">";          
         
      //calculate needed pages
      $pa = ceil($pageNumber['cnt'] / MAX_ENTRY_NUMBER);

      //Previous button, if page 1 is selected button gets deactivated
      if($_GET['page'] == 1){
                  echo "<li class=\"disabled\"><a href=\"\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
               }else{
                  echo '<li><a href="menu.php?menu='.$_GET['thread'].'&page='.($_GET['page']-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
            }
            //if only one page is needed add this one custom
            if($pa == 0){
               echo '<li class="active"><a href="menu.php?menu='.$_GET['menu'].'&page=1">1</a></li>';   
            }

            if($pa > 7){
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
                  echo '<li><a href="thread.php?thread='.$_GET['thread'].'&page='.($_GET['page']+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
            }
         
         echo '</ul></nav>';
         
      }
      
   function createSingleMenuPoint($nr){
       if($_GET['page']==$nr){
          echo '<li class="active"><a href="thread.php?thread='.$_GET['thread'].'&page='.$nr.'">'.$nr.'</a></li>';   
       }else{
          echo '<li><a href="thread.php?thread='.$_GET['thread'].'&page='.$nr.'">'.$nr.'</a></li>';   
       }
   }
         
   function createBreadcrumb($id){
      
    echo '<div class="row"><ol class="breadcrumb">
    <li><a href="menu.php?menu=0&page=1">Main menu</a></li>';
    recursiveBreadCrumb($id);
    $title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = " .$_GET['thread']);
    echo '<li class="active">'.$title['theme'].'</li>';

    echo "</ol></div>";

 }
         
   function recursiveBreadCrumb($id){

      $tempQuery = SQLQuery("SELECT * FROM menu WHERE PKID_menu = ".$id);

      if($tempQuery['FK_menu']==NULL){
         echo '<li><a href="menu.php?menu='.$tempQuery['PKID_menu'].'&page=1">'.$tempQuery['title'].'</a></li>';
         return;
      }

      recursiveBreadCrumb($tempQuery['FK_menu']);

         echo '<li><a href="menu.php?menu='.$tempQuery['PKID_menu'].'&page=1">'.$tempQuery['title'].'</a></li>';

   }
         
   function createThema(){

      $title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$_GET['thread']);

      echo "<h3>".$title['theme']."</h3>";
 }
         
   function getLastPage(){
      $pageNumber = SQLQuery("SELECT COUNT(PKID_post) as cnt FROM post WHERE FK_thread = ".$_GET['thread']);
      return ceil($pageNumber['cnt'] / MAX_ENTRY_NUMBER);  
   }       


?>

