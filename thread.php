<?php
   require 'func/threadfunc.php';
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
         require 'func/navbar.php';
         const MAX_ENTRY_NUMBER = 5;
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
         $thread = SQLQuery("SELECT FK_menu FROM thread WHERE PKID_thread = " .$_GET['thread']);
         $menupoint = SQLQuery("SELECT * FROM menu WHERE PKID_menu = " .$thread['FK_menu']);
      
         createBreadcrumb($thread['FK_menu']);
         create2ndRow();
         createPostOverview();
         create2ndRow();
         
      ?>
      
      </div>
	  
	  <script>
	  function alert(){
		  alert("test");
	  }
	  </script>
   
      <?php include_once('func/footer.html'); ?>
   </body>
</html>