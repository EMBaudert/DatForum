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
            $sqlString= "SELECT PKID_menu, title FROM menu WHERE FK_menu IS NULL";
         }else{
            $sqlString = "SELECT PKID_menu, title FROM menu WHERE FK_menu  = ".$_GET['menu'];
         }
      }else{
         $sqlString= "SELECT PKID_menu, title FROM menu WHERE FK_menu IS NULL";
      }
  
   
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      

      
      createMenu($pdo, $sqlString);
      


      function createMenuPoint($title, $count, $nextPoint){
         echo "<li class=\"list-group-item\">";
         echo "<div class=\"container\">
            <div class=\"row\">
               <div class=\"col-xs-12 col-sm-12 col-md-9 col-lg-9\"><a href=\"sqltest.php/?menu=".$nextPoint."\">".$title."</a></div>
               <div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\">".$count."</div>
            </div>
         </div>";
         
         echo "</li>";
      } 
      
      function createMenuPointBack($upperMenu){
         echo "<li class=\"list-group-item\">";
         echo "<div class=\"container\">
            <div class=\"row\">
               <div class=\"col-xs-12 col-sm-12 col-md-9 col-lg-9\"><a href=\"sqltest.php/?menu=".$upperMenu."\">...</a></div>
            </div>
         </div>";
         
         echo "</li>";
      }
      
      function createMenu($pdo, $sqlString) {

         if (strpos($sqlString, 'NULL') !== false) {
            $back = -1;
         }else{
            $back=0;
            }
         
         

         
         
         //for each menu entry is null (means main entry)
         foreach ($pdo->query($sqlString) as $row) {
            
            if($back == 0){
               
               createMenuPointBack($row['title']);
               $back = 1;
               
            }
            
            echo $row['FK_menu'];
            
            //get number of sub entries
            $count = $pdo->query("SELECT COUNT(FK_menu) as cnt FROM menu WHERE FK_menu = ".$row['PKID_menu']);
            $count->execute();
            $number = $count->fetch();            

            createMenuPoint($row['title'],$number['cnt'], $row['PKID_menu']);

         }
         echo "</div></ul>";
      }    
      
   ?>
   
   
   </body>
</html>