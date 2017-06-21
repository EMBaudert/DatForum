<html>

   <?php
      require_once 'func/menu.func.php';
   ?>

   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">

   <!-- Latest compiled and minified JavaScript -->
   <script src="bootstrap/jquery-3.2.1.min.js"></script>
   <script src="bootstrap/less/dist/js/bootstrap.min.js"></script>

   <head>
      <title>Forum</title>
   </head>
   
   <body>
   
   <div class="container">
   
      <?php
      
      require_once 'inc/navbar.php';
      
      const MAX_ENTRY_NUMBER = 1;
   
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   
   
      if(!isset($_GET['menu'])){
         $_GET['menu'] = "0";
      }
      if(!isset($_GET['page'])){
         $_GET['page'] = "1";
      }
      createBreadcrumb($_GET['menu']);
  
  
   //GET gets previous menu point, for main menu number is 0
         if($_GET['menu'] == "0"){
            $sqlString= "SELECT * FROM menu WHERE FK_menu IS NULL";
         }else{
            $sqlString = "SELECT * FROM menu WHERE FK_menu  = ".$_GET['menu'];
         }
      
      //check if thread true, dann createThreadOverview()
      $checkThread = SQLQuery("SELECT threads FROM menu WHERE PKID_menu = ". $_GET['menu']);
      if($checkThread['threads']){
         create2ndRow(1);
         createThreadOverview($_GET['menu']);
         create2ndRow(1);
      }else {
         create2ndRow(0);
         createMenu($sqlString);    
         create2ndRow(0);     
      }
      include_once('inc/footer.html');
   
   ?>
   
   </div>
   
   </body>
</html>