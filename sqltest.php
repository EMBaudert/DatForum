<html>
   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

   <!-- Das neueste kompilierte und minimierte JavaScript -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

   <head>
      <title>Forum</title>
   </head>
   
   <body>
   
   <div class="container">
   
   <?php
      const MAX_ENTRY_NUMBER = 5;
   
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   
   
      if(!isset($_GET['menu'])){
         $_GET['menu'] = "0";
      }
      if(!isset($_GET['page'])){
         $_GET['page'] = "0";
      }
      
      createBreadcrumb($_GET['menu']);
  
  
   //GET gets previous menu point, for main menu number is 0
         if($_GET['menu'] == "0"){
            $sqlString= "SELECT * FROM menu WHERE FK_menu IS NULL";
         }else{
            $sqlString = "SELECT * FROM menu WHERE FK_menu  = ".$_GET['menu'];
         }
      

      
      
      //check if thread true, dann createThreadOverview()
      if(isset($_GET['thread'])){
         createThreadOverview($_GET['thread']);
      }else {
         createMenu($sqlString);         
      }
   
      


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
         
      
         echo "<li class=\"list-group-item\">";
         echo "<div class=\"container\">
                  <div class=\"row\">
                     <div class=\"col-xs-12 col-sm-12 col-md-10 col-lg-10\"><a href=\"sqltest.php?".$ausgabe."\">".$title."</a></div>";
         
          echo     "<div class=\"col-xs-12 col-sm-12 col-md-2 col-lg-2\">".$count."</div>";
        
         
         echo     "</div>
               </div>";
         
         echo "</li>";
      } 
      
      
      function createMenuPointBack(){
         
         
         
         $upperMenu = SQLQuery("SELECT FK_menu FROM menu WHERE PKID_menu=".$_GET['menu']);;
         
         if($upperMenu['FK_menu']==NULL){
            $upperMenu['FK_menu']=0;
         }

         echo "<li class=\"list-group-item\">";
         echo "<div class=\"container\">
            <div class=\"row\">
               <div class=\"col-xs-12 col-sm-12 col-md-9 col-lg-9\"><a href=\"sqltest.php?menu=".$upperMenu['FK_menu']."&page=1\">...</a></div>
            </div>
         </div>";
         
         echo "</li>";
         
         
      }
      
      function createMenu($sqlString) {
         global $pdo;
         
         createPagination();
         
         echo "<div class=\"container\"><ul class=\"list-group\">";
         
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
         echo "</div></ul>";
      } 
      
      function checkThread($PKID){
      
         $temp= SQLQuery("SELECT COUNT(PKID_thread) as num FROM thread WHERE FK_menu = ".$PKID);
         return $temp['num'];
      }
      
      
      
      function createThreadOverview($id){
         global $pdo;
         
         createPagination();
 
         echo "<div class=\"container\"><ul class=\"list-group\">";
         
         createMenuPointBack();
         
         foreach($pdo->query("SELECT * FROM thread WHERE FK_menu = ".$id)as $row){
            createThreadEntry($row['PKID_thread'], $row['theme'], $row['FK_creator']); 
         }
         
         echo "</div></ul>";         
         
      }
      
      function createThreadEntry($PKID, $title, $creator){
      
         $username = SQLQuery("SELECT username FROM user WHERE PKID_user = ".$creator);;
         
         echo "<li class=\"list-group-item\">
            <div class=\"container\">
               <div class=\"row\">
               
                  <div class=\"col-xs-12 col-sm-12 col-md-8 col-lg-8\"><a href=\"sqltest.php?menu=".$PKID."&page=1\">".$title."</a></div>
                  <div class=\"col-xs-6 col-sm-6 col-md-2 col-lg-2\"><a href=\"user.php?user=".$creator."\">".$username['username']."</a></div>
                  <div class=\"col-xs-6 col-sm-6 col-md-2 col-lg-2\">Beitr&auml;ge: ".getPostNumber($PKID)."</div>
               </div>
            </div>
            </li>";
         
      }
      
      function getPostNumber($id){
         
         $tempNr = SQLQuery("SELECT COUNT(PKID_post) as num FROM post WHERE FK_thread = ".$id);
         return $tempNr['num'];
      }
      
      function createBreadcrumb($id){
      
         echo "<div class=\"container\">
         <ol class=\"breadcrumb\">
         <li><a href=\"sqltest.php?menu=0&page=1\">Main menu</a></li>";
         recursiveBreadCrumb($id,1);
         
         echo "</ol></div>";
         
      }
      
      function recursiveBreadCrumb($id, $first){

         $tempQuery = SQLQuery("SELECT * FROM menu WHERE PKID_menu = ".$id);
         
         if($tempQuery['FK_menu']==NULL){
            echo "<li><a href=\"sqltest.php?menu=".$tempQuery['PKID_menu']."&page=1\">".$tempQuery['title']."</a></li>";
            return;
         }
         
         recursiveBreadCrumb($tempQuery['FK_menu'],0);
         //If first
         if($first == 0){
            echo "<li><a href=\"sqltest.php?menu=".$tempQuery['PKID_menu']."&page=1\">".$tempQuery['title']."</a></li>";
         }else{
            echo "<li class=\"active\">".$tempQuery['title']."</li>";
         }
         
      }
      
      function SQLQuery($query){
         global $pdo;
         
         $temp=$pdo->query($query);
         $temp->execute();
         return $temp->fetch();
         
      }
      
      function createPagination(){
         
         //getPagenumber
         if($_GET['menu']==0){
            $pageNumber = SQLQuery("SELECT COUNT(PKID_menu) as cnt FROM menu WHERE FK_menu IS NULL");
         }else{
            $pageNumber = SQLQuery("SELECT COUNT(FK_menu) as cnt FROM menu WHERE FK_menu = ".$_GET['menu']);
         }
         echo $pageNumber['cnt'];
         echo "<div class=\"container\">
               <nav aria-label=\"pagination\">
               <ul class=\"pagination\">";          
         
            //calculate needed pages
            $pa = $pageNumber['cnt'] / MAX_ENTRY_NUMBER;

            //Previous button, if page 1 is selected button gets deactivated
            if($_GET['page'] == 1){
                  echo "<li class=\"disabled\"><a href=\"\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
               }else{
                  echo "<li><a href=\"sqltest.php?menu=".$_GET['menu']."&page=".($_GET['page']-1)."\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
            }

            //show all pages
            for($i=1;$i<$pa+1; $i++){
               if($_GET['page']==$i){
                  echo "<li class=\"active\"><a href=\"sqltest.php?menu=".$_GET['menu']."&page=".$i."\">".$i."</a></li>";   
               }else{
                  echo "<li><a href=\"sqltest.php?menu=".$_GET['menu']."&page=".$i."\">".$i."</a></li>";   
               }
               $maxPages=$i;
            }
            
            //last button, if last site is selected buttons get deactivated
            if($_GET['page'] == $pa){
                  echo "<li class=\"disabled\"><a href=\"\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
               }else{
                  echo "<li><a href=\"sqltest.php?menu=".$_GET['menu']."&page=".($_GET['page']+1)."\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
            }
         
         echo "</ul></nav></div>";
         
      }
      
      
   ?>
   
   </div>
   
   </body>
</html>