<html>

   <?php
      require_once 'func/menufunc.php';
   ?>

   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
   <link rel="stylesheet" href="layout/style.css">

   <!-- Latest compiled and minified JavaScript -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	

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
   
   ?>
   
   </div>
   
         <?php include_once('inc/footer.html'); ?>
   
   </body>
</html>