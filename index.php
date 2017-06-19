<?PHP
require_once 'func/menufunc.php';
?>
<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>DatForum - Startseite</title>
			<link rel="SHORTCUT ICON" href="layout/icon.ico" />
         <!-- Das neueste kompilierte und minimierte CSS -->
         <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

         <!-- Optionales Theme -->
         <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
         <link rel="stylesheet" href="style.css">

         <!-- Latest compiled and minified JavaScript -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      	
		</head>
		<body>
			<div class="container">
			<?php
           require_once 'inc/navbar.php';
         ?>
			   <h1>Startseite</h1>
            <p><a href="menu.php">Menu</a></p>
         </div>
			<?php
           include_once 'inc/footer.html';
         ?>
         
		</body>
	</html>