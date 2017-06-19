<?php
	session_start();

	$_SESSION["PKID"] = 1;
?>


<html>

   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

   <link rel="stylesheet" href="style.css">

   <!-- Das neueste kompilierte und minimierte JavaScript   
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
   
   

   <head>
      <title>Thread</title>
   </head>
   <body>
   
      <div class="container">
   
      <?php
         const MAX_ENTRY_NUMBER = 5;
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
         $thread = SQLQuery("SELECT FK_menu FROM thread WHERE PKID_thread = " .$_GET['thread']);
         $menupoint = SQLQuery("SELECT * FROM menu WHERE PKID_menu = " .$thread['FK_menu']);
      
         createBreadcrumb($thread['FK_menu']);
         create2ndRow();
         createPostOverview();
         create2ndRow();
         
         function create2ndRow(){
         global $pdo;
            
            $title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$_GET['thread']);
         
            echo "<div class=\"row\">
               <div class=\"col-xs-12 col-sm-12 col-md-8 col-lg-8 pag-offset\">
                  <h3>".$title['theme']."</h3>
               </div>
               <div class=\"col-xs-12 col-sm-12 col-md-2 col-lg-2 pag-offset\">
                  <div class=\"btn-group\" role=\"group\">
                     <div type=\"button\" class=\"btn btn-default \">
                        <span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span> Neuer Beitrag
                     </div>
                  </div>
               </div>
               <div class=\"col-xs-6 col-sm-6 col-md-2 col-lg-2 pag-offset\">"; 
                  createPagination();
               echo "</div>
            </div>";
               
         }
      
         function createPostOverview(){
            global $pdo;
         
               //createPagination(0);
               
               echo "<div class=\"row\"><ul class=\"list-group\">";
               
               $i=0;
               foreach ($pdo->query("SELECT * FROM post WHERE FK_thread = ".$_GET['thread']) as $row) {
               
                  if($i>= ($_GET['page']-1*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
                   
                     createPost($row);
                  }
                  $i++;            
               }
               
               echo "</ul></div>";
         }    
      
         function createPost($post){
         
            $user = SQLQuery("SELECT * FROM user WHERE PKID_user = ".$post['FK_user']);
            $title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$post['FK_thread']);
            

 		//<hr class=\"colorline\">                  <div class=\".row\"></div>
            echo "

                  <div class=\"panel panel-primary\">
                     <div class=\"panel-heading\">
            				".$post['date']." ".$post['time']."
            			</div>
            			
                     <div class=\"row equal\">
               			<div class=\"col-xs-12 col-sm-12 col-md-2 col-lg-2 post-userinfo \">
               				<p><a href=user.php?user=".$post['FK_user'].">".$user['username']."</a><br>"
               				.$user['group']."</p>
               				<p>Bild</p>
               			
               			</div>
               			<div class=\"col-xs-12 col-sm-12 col-md-10 col-lg-10 post-content\">
               				<p><b>".$title['theme']."</b></p>
               				<hr>
               				<p class=\"content\">".$post['text']."</p>
               				<hr>
               				<p>".$user['signature']."</p>
               			</div>
               		</div>
            			
            			<div class=\"panel-footer \">
                        <div class=\"row footer-color\">
                           <div class=\"btn-group pull-right\" role=\"group\">";
						   
							if($user['PKID_user'] == $_SESSION["PKID"]){
							echo "<a class =\"btn btn-default\" href=\"javascript:alert()\">Edit</a>";	
								
							}
						   
							echo      "<a class =\"btn btn-default\" href=\"javascript:alert()\">Melden</a>
                              <a class =\"btn btn-default\" href=\"javascript:alert()\">Zitieren</a>

                           </div>
                        </div>
            			</div>
                  </div>";

         }
         
         function createPagination(){
            //getPagenumber
         

            $pageNumber = SQLQuery("SELECT COUNT(PKID_post) as cnt FROM post WHERE FK_thread = ".$_GET['thread']);
            
         
    //     echo $pageNumber['cnt'];
              echo "<nav aria-label=\"pagination\">
              
               <ul class=\"pagination pull-right\">";          
         
            //calculate needed pages
            $pa = $pageNumber['cnt'] / MAX_ENTRY_NUMBER;

            //Previous button, if page 1 is selected button gets deactivated
            if($_GET['page'] == 1){
                  echo "<li class=\"disabled\"><a href=\"\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
               }else{
                  echo "<li><a href=\"thread.php?thread=".$_GET['thread']."&page=".($_GET['page']-1)."\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
            }

            //show all pages
            for($i=1;$i<$pa+1; $i++){
               if($_GET['page']==$i){
                  echo "<li class=\"active\"><a href=\"thread.php?thread=".$_GET['thread']."&page=".$i."\">".$i."</a></li>";   
               }else{
                  echo "<li><a href=\"thread.php?thread=".$_GET['thread']."&page=".$i."\">".$i."</a></li>";   
               }
               $maxPages=$i;
            }
            //last button, if last site is selected buttons get deactivated
            if($_GET['page'] == ceil($pa)){
                  echo "<li class=\"disabled\"><a href=\"\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
               }else{
                  echo "<li><a href=\"thread.php?thread=".$_GET['thread']."&page=".($_GET['page']+1)."\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
            }
         
         echo "</ul></nav>";
         
         }
         
         function createBreadcrumb($id){
      
            echo "<div class=\"row\"><ol class=\"breadcrumb\">
            <li><a href=\"menu.php?menu=0&page=1\">Main menu</a></li>";
            recursiveBreadCrumb($id);
            $title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = " .$_GET['thread']);
            echo "<li class=\"active\">".$title['theme']."</li>";
            
            echo "</ol></div>";
            
         }
         
         function recursiveBreadCrumb($id){

            $tempQuery = SQLQuery("SELECT * FROM menu WHERE PKID_menu = ".$id);
            
            if($tempQuery['FK_menu']==NULL){
               echo "<li><a href=\"menu.php?menu=".$tempQuery['PKID_menu']."&page=1\">".$tempQuery['title']."</a></li>";
               return;
            }
            
            recursiveBreadCrumb($tempQuery['FK_menu']);
            
               echo "<li><a href=\"menu.php?menu=".$tempQuery['PKID_menu']."&page=1\">".$tempQuery['title']."</a></li>";
            
         }
         
         function createThema(){
            global $pdo;
            
            $title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$_GET['thread']);
            
            echo "<h3>".$title['theme']."</h3>";
         }
         
         function SQLQuery($query){
            global $pdo;
            
            $temp=$pdo->query($query);
            $temp->execute();
            return $temp->fetch();
            
         }
      
      ?>
      
      </div>
	  
	  <script>
	  function alert(){
		  alert("test");
	  }
	  </script>
   
   </body>
</html>