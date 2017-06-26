<?PHP
require_once 'func/index.func.php';
?>
<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>DatForum - Startseite</title>
			<link rel="SHORTCUT ICON" href="layout/icon.ico" />
         <!-- Das neueste kompilierte und minimierte CSS -->
         <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

         <!-- Optionales Theme -->
         <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">
         <!-- Latest compiled and minified JavaScript -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
         <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
         
		</head>
		<body>
			<div class="container">
			<?php
           require_once 'inc/navbar.php';
            if(isset($_SESSION['PKID'])){ 
               echo '<h2> Hallo '.getUsername($_SESSION['PKID']);
               if(checkMessages($_SESSION['PKID'])){
                  echo ', du hast <a href="messages.php">ungelesene Nachrichten!</a></h2>';
               }else{
                  echo ', schau dir ein paar aktuelle Beitr&auml;ge an!</h2>';
               }
            }      
            
            echo '<div class="row">';
           createTopPosts("Meiste Antworten","SELECT FK_thread, COUNT(*) FROM post GROUP BY FK_thread ORDER BY COUNT(*) DESC");
                  
           createTopPosts("Neueste Beitr&auml;ge","SELECT FK_thread, date, time  FROM post GROUP BY FK_thread ORDER BY date DESC, time DESC");
           echo '</div>';
           include_once 'inc/footer.html';
         ?>
         </div>
         
		</body>
	</html>