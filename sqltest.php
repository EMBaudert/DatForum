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
   
      if(isset($_GET['menu'])){
      
      //GET gets previous menu point, for main menu number is 0
         if($_GET['menu'] == "0"){
            $sqlString= "SELECT * FROM menu WHERE FK_menu IS NULL";
         }else{
            $sqlString = "SELECT * FROM menu WHERE FK_menu  = ".$_GET['menu'];
         }
      }else{
         $sqlString= "SELECT * FROM menu WHERE FK_menu IS NULL";
      }
  
   
      
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      

      //check if thread true, dann createThreadOverview()
      createMenu($sqlString);
      


      function createMenuPoint($title, $count, $nextPoint, $threads){
         global $pdo;
      
         echo "<li class=\"list-group-item\">";
         echo "<div class=\"container\">
                  <div class=\"row\">
                     <div class=\"col-xs-12 col-sm-12 col-md-10 col-lg-10\"><a href=\"sqltest.php?menu=".$nextPoint."\">".$title."</a></div>";
         
         if($threads){
            echo        "<div class=\"col-xs-12 col-sm-12 col-md-2 col-lg-2\">Threads: ".checkThread($nextPoint)."</div>";
         }else{
            echo       "<div class=\"col-xs-12 col-sm-12 col-md-2 col-lg-2\">Unterpunkte: ".$count."</div>";
        }
         
         echo     "</div>
               </div>";
         
         echo "</li>";
      } 
      
      function createMenuPointBack($sqlString,$fk_menu){
         global $pdo;
      
      
         if (strpos($sqlString, 'NULL') !== false)
            return;
  
         $tempMenu = $pdo->query("SELECT FK_menu FROM menu WHERE PKID_menu=".$fk_menu);
         $tempMenu->execute();
         $upperMenu = $tempMenu->fetch();

         if($upperMenu['FK_menu'] == NULL)
            $upperMenu['FK_menu'] = 0;
         
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
         
         $back = 1;
         
         foreach ($pdo->query($sqlString) as $row) {
            if($back){
               createMenuPointBack($sqlString,$row['FK_menu']);
               $back=0;
            }    
           
            
//get number of sub entries
            $count = $pdo->query("SELECT COUNT(FK_menu) as cnt FROM menu WHERE FK_menu = ".$row['PKID_menu']);
            $count->execute();
            $number = $count->fetch();            

            createMenuPoint($row['title'],$number['cnt'], $row['PKID_menu'],$row['threads']);

         }
         echo "</div></ul>";
      } 
      
      function checkThread($PKID){
         global $pdo;
      
         $temp=$pdo->query("SELECT COUNT(PKID_thread) as num FROM thread WHERE FK_menu = ".$PKID);
         $temp->execute();
         $tempNr = $temp->fetch();
         return $tempNr['num'];
      }
      
      
      
      function createThreadOverview($id){
         global $pdo;
         
      }
      
      function createThreadEntry(){
         
         
      }
      
   ?>
   
   
   </body>
</html>