<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>DatForum - Error</title>
			<link rel="SHORTCUT ICON" href="../layout/favicon.ico" />
         <!-- Das neueste kompilierte und minimierte CSS -->
         <link rel="stylesheet" href="../bootstrap/less/dist/css/bootstrap.min.css">

         <!-- Optionales Theme -->
         <link rel="stylesheet" href="../bootstrap/less/dist/css/bootstrap-theme.min.css">
         <!-- Latest compiled and minified JavaScript -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
         <script src="../bootstrap/less/dist/js/bootstrap.min.js" ></script>
         
		</head>
		<body>
			<div class="container">
				<h1>Error XY</h1>
            <h2>Bitte aktivieren Sie JavaScript um diese Seite sehen zu k&ouml;nnen!</h2>
            <?PHP
            session_start();
            if(isset($_SESSION["url"])){
               echo '<a href="'.$_SESSION["url"].'">Zur&uuml;ck</a>';
            }else{
               echo '<a href="../index.php">Zur&uuml;ck</a>';
            }
            ?>
                  </div>
         
         </div>
		</body>
	</html>