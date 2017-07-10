<?PHP
require_once 'func/reports.func.php';
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
         <script src="bootstrap/jquery-3.2.1.min.js"></script>
         <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
         
		</head>
		<body>
			<div class="container">

   			<?php
            require_once 'inc/navbar.php';
            if(isset($_SESSION['PKID'])){
               $user = SQLQuery1("SELECT * FROM user WHERE PKID_user= ?", $_SESSION['PKID']);
                  if($user['usergroup']== 'admin' || $user['usergroup']== 'moderator' ){
                     createReportsOverview();
                  }else{
                     echo '<h2>Error: Permission denied</h2>';
                  }
            }else{
               echo '<h2>Error: You need to be logged in</2>';
            }
            ?>
         </div>
		</body>
      
       <script>
            $(document).ready(function(){
               $('#solved').button().click(function(){
                  if (confirm('Erledigt?')) {
                       var query1part = "UPDATE `reports` SET `done` = 1, `doneby` = '"; 
                       var query2part = "' WHERE `reports`.`PKID_report` = 1 ";
                       var sql = {
                           type: 'reportdone',
                           query1: query1part,
                           query2: query2part
                        }
                        
                        $.post("func/insertSQL.php",sql, function(result){
                        
                        });
                        
                       }
                  
               });            
            });
         </script>
      
	</html>