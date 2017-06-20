<?php
   require 'func/thread.func.php';
?>


<html>

   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">

   <link rel="stylesheet" href="layout/style.css">
   <!-- Latest compiled and minified JavaScript -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
	

   <head>
      <title>Thread</title>
   </head>
   <body>
   
      <div class="container">
   
      <?php
         require 'inc/navbar.php';
         const MAX_ENTRY_NUMBER = 5;
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
         if(!isset($_GET['thread']) && !isset($_GET['page'])){
            echo "<meta http-equiv=\"refresh\" content=\"0; URL=index.php\" />";
         }
         $thread = SQLQuery("SELECT FK_menu FROM thread WHERE PKID_thread = " .$_GET['thread']);
         $menupoint = SQLQuery("SELECT * FROM menu WHERE PKID_menu = " .$thread['FK_menu']);
      
         createBreadcrumb($thread['FK_menu']);
         create2ndRow();
         createPostOverview();
         create2ndRow();
         
      ?>
      
      <?php include_once('inc/footer.html'); ?>         
         
      </div>

   </body>
</html>