<!DOCTYPE html>
<html>

   <link rel="SHORTCUT ICON" href="layout/favicon.ico" />
   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">

   <!-- Latest compiled and minified JavaScript -->
   <script src="bootstrap/jquery-3.2.1.min.js"></script>
   <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
	<audio autoplay="true" loop="trueM" class="hide" controls>
      <source src="inc/backgroundsong.mp3" type="audio/mpeg">
   </audio>
   <head>
      <title id="pageTitle">DatForum</title>
   </head>
   <body>
   
      <div class="container">
   
      <?php
         require 'inc/navbar.php';
         
         switch($_GET['p']){
            case 'postoverview':
               require 'inc/forum/post.php';
               break;
            case 'createThread':
               require 'inc/forum/createThread.php';
               break;
            case 'createPost':
               require 'inc/forum/createPost.php';
               break;
            case 'thread';
               require 'inc/forum/thread.php';
               break;
            case 'menu';
               require 'inc/forum/menu.php';
               break;
            case 'search';
               require 'inc/forum/search.php';
               break;
            case 'post':
               require 'inc/forum/post.php';
               break;
         }
  
         
         include_once('inc/footer.html');
      ?>
      
      </div>
   </body>
</html>