<?PHP
require_once 'func/index.func.php';
?>
<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>DatForum - Startseite</title>
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
           
           //Soll nur angezeigt werden wenn man angemeldet ist
            if(isset($_SESSION['PKID'])){ 
               echo '<div class="row"><h2> Hallo '.getUsername($_SESSION['PKID']);
               $msg_cnt = checkMessages($_SESSION['PKID']);
               if($msg_cnt > 0){
                  echo ', du hast <a href="messages.php">'.$msg_cnt.' ungelesene Nachrichten!</a></h2>';
               }else{
                  echo ', schau dir ein paar aktuelle Beitr&auml;ge an!</h2></div>';
               }
            }      
            //Ab hier für alle anzeigen
            // zuerst link zum Forum, danch mit php und SQL spezielle themen
            echo '<div class="row">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           Zum Forum
                        </div>
                        <div class="panel-body">
                           <span class="glyphicon glyphicon-list"></span> <a href="menu.php">Zur &Uuml;bersicht</a>
                        </div>
                     </div>
                  </div>';
                     $d = getdate();
               //Meisten neue Kommentare (seit 2 Tagen)         
               createTopPosts("Meist diskutiert","SELECT FK_thread, COUNT(*) FROM post WHERE date> '".$d['year']."-".$d['mon']."-".($d['mday']-5)."' GROUP BY FK_thread ORDER BY COUNT(*) DESC");
               // Meiste beträge generell
               createTopPosts("Meiste Beitr&auml;ge","SELECT FK_thread, COUNT(*) FROM post GROUP BY FK_thread ORDER BY COUNT(*) DESC");
               //Neueste Beiträge
               createTopPosts("Neueste Themen","SELECT FK_thread, date, time  FROM post GROUP BY FK_thread ORDER BY date DESC, time DESC");
            
           include_once 'inc/footer.html';
         ?>
         </div>
		</body>
	</html>