<?php
   require 'func/thread.func.php';
?>

<!DOCTYPE html>
<html>

   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">

   <!-- Latest compiled and minified JavaScript -->
   <script src="bootstrap/jquery-3.2.1.min.js"></script>
   <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
	
   <head>
      <title>Threadansicht</title>
   </head>
   <body>
   
      <div class="container">
   
      <?php
         require 'inc/navbar.php';
         
         switch($_GET['p']){
            case 'reports':
               require 'inc/reports.php';
               break;
            case 'postoverview':
               require 'inc/postOverview.php';
               break;
            case 'createPost':
               require 'inc/createPost.php';
               break;
            case 'createPost':
               require 'inc/createPost.php';
               break;
         }
  
         
         include_once('inc/footer.html');
      ?>
      
      </div>
   </body>
</html>