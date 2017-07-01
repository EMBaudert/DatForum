<?php
   require_once 'func/posts.func.php';
?>
<!DOCTYPE html>
<html>
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
             require 'inc/navbar.php';
         //gibt an wieviele threads auf eine Seite dürfen
         const MAX_ENTRY_NUMBER = 2;
            create2ndRow();
            createPostOverview();
         ?>
    
      </div>
   </body>
</html>