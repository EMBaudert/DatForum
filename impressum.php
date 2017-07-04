<?PHP
require_once 'func/index.func.php';
?>
<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>DatForum - Impressum</title>
			<link rel="SHORTCUT ICON" href="layout/favicon.ico" />
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
           ?>
           <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <h1>Impressum</h1>
                  <h4>
                        &copy; 2017 by DatForum-Team*:<br>
                     <a href="intern.php?p=profile&uid=1">Rino Grupp</a><br>
                     <a href="intern.php?p=profile&uid=2">Merlin Baudert</a><br>
                  </h4>
                  <p>Die Seiten wurden ausschlie&szlig;lich von diesem Team im Rahmen eines Web-Engineering
                      Projekts entworfen und unterst&uuml;tzt. </p>
                  <p>Aus Presserechtlichen Gr&uuml;nden betonen wir, dass wir keinerlei Einfluss auf von Nutzern erstellte Beitr&auml;ge
                     und verlinkte Seiten haben. Falls Ihnen unannehmliche Inhalte auffallen, melden Sie bitte die betreffenden Beitr&auml;ge
                     und unsere Moderatoren und Administratoren werden sich darum k&uuml;mmern.<br>
                     Richtlinien und Hinweise zum Datenschutz entnehmen Sie bitte unseren <a href="documents/Hinweise_zu_Richtlinien_und_Datenschutzbestimmungen.pdf" target="_blank" onclick="alert('Fehler! Verweis nicht gefunden!');">
                     Hinweise zu Richtlinien und Datenschutzbestimmungen </a>.
                  </p>
               </div>
               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <h1>DHBW Stuttgart</h1>
                  <h4>*Kurs STG-TINF16D<br>Rotheb&uuml;hlplatz 41/1<br>D-70178 Stuttgart<br></h4>
               </div>
           </div>
           <?PHP
           include_once 'inc/footer.html';
         ?>
         </div>
         
		</body>
	</html>