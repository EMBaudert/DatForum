<html>
   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

   <!-- Das neueste kompilierte und minimierte JavaScript -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

   <head>
      <title>Forum</title>
   </head>
   
   <body>
   
   <?php
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   
   
      if(isset($_GET['menu'])){
      
      //GET gets previous menu point, for main menu number is 0
         if($_GET['menu'] == "0"){
            $sqlString= "SELECT * FROM menu WHERE FK_menu IS NULL";
         }else{
            $sqlString = "SELECT * FROM menu WHERE FK_menu  = ".$_GET['menu'];
         }
               createBreadcrumb($_GET['menu']);
      }else{
         $sqlString= "SELECT * FROM menu WHERE FK_menu IS NULL";
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
            $ausgabe = "menu=".$nextPoint."&thread=".$nextPoint;
         }else{
            $ausgabe = "menu=".$nextPoint;
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
         
         if($_GET['menu']==0){
            return;
         }
         
         $upperMenu = SQLQuery("SELECT FK_menu FROM menu WHERE PKID_menu=".$_GET['menu']);;
         
         if($upperMenu['FK_menu']==NULL){
            $upperMenu['FK_menu']=0;
         }

         echo "<li class=\"list-group-item\">";
         echo "<div class=\"container\">
            <div class=\"row\">
               <div class=\"col-xs-12 col-sm-12 col-md-9 col-lg-9\"><a href=\"sqltest.php?menu=".$upperMenu['FK_menu']."\">...</a></div>
            </div>
         </div>";
         
         echo "</li>";
         
         
      }
      
      function createMenu($sqlString) {
         global $pdo;
         
         echo "<div class=\"container\"><ul class=\"list-group\">";
         
         createMenuPointBack();
         
         foreach ($pdo->query($sqlString) as $row) {
            
//get number of sub entries
            $number = SQLQuery("SELECT COUNT(FK_menu) as cnt FROM menu WHERE FK_menu = ".$row['PKID_menu']);            

            createMenuPoint($row['title'],$number['cnt'], $row['PKID_menu'],$row['threads']);

         }
         echo "</div></ul>";
      } 
      
      function checkThread($PKID){
      
         $temp= SQLQuery("SELECT COUNT(PKID_thread) as num FROM thread WHERE FK_menu = ".$PKID);
         return $temp['num'];
      }
      
      
      
      function createThreadOverview($id){
         global $pdo;
 
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
               
                  <div class=\"col-xs-12 col-sm-12 col-md-8 col-lg-8\"><a href=\"sqltest.php?menu=".$PKID."\">".$title."</a></div>
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
         <li><a href=\"sqltest.php?menu=0\">Main menu</a></li>";
         recursiveBreadCrumb($id,1);
         
         echo "</ol></div>";
         
      }
      
      function recursiveBreadCrumb($id, $first){

         $tempQuery = SQLQuery("SELECT * FROM menu WHERE PKID_menu = ".$id);
         

         
         if($tempQuery['FK_menu']==NULL){
            echo "<li><a href=\"sqltest.php?menu=".$tempQuery['PKID_menu']."\">".$tempQuery['title']."</a></li>";
            return;
         }
         
         recursiveBreadCrumb($tempQuery['FK_menu'],0);
         if($first = 0){
            echo "<li><a href=\"sqltest.php?menu=".$tempQuery['PKID_menu']."\">".$tempQuery['title']."</a></li>";
         }else{
            echo "<li class=\"active\"><a href=\"sqltest.php?menu=".$tempQuery['PKID_menu']."\">".$tempQuery['title']."</a></li>";
         }
         
      }
      
      function SQLQuery($query){
         global $pdo;
         
         $temp=$pdo->query($query);
         $temp->execute();
         return $temp->fetch();
         
         
      }
      
      
   ?>
   
   
   </body>
</html>