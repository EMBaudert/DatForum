<!--
Diese Seite wird immer aufgerufen, sobald der Nutzer Javascript deaktiviert hat, da unsere Seite ohne Javascript nicht funktioniert.
Sobald man Javascript aktiviert hat, kommt man auf die letzte Seite, auf der man war, als Javascript deaktiviert wurde.
-->

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
            if(isset($_SESSION["url"])){        #In der Session-Variable "url" wird die aktuelle Seite gespeichert. Dies ermöglicht es dem Nutzer, sich einzuloggen und wieder auf die aktuelle Seite zu gelangen.
               echo '<a href="'.$_SESSION["url"].'">Zur&uuml;ck</a>';
            }else{
               echo '<a href="../index.php">Zur&uuml;ck</a>';
            }
            ?>
                  </div>
         
         </div>
		</body>
	</html>