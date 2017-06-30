<!DOCTYPE html>
<?PHP
require_once 'func/user.func.php';
require_once 'func/menu.func.php';
?>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>DatForum - Intern</title>
			<link rel="SHORTCUT ICON" href="layout/favicon.ico" />
			<link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

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
     
				if(!isset($_GET["p"])){
					echo "Keine bekannte Seite!";
				}elseif($_GET["p"]=="login"){
					if(!isset($_SESSION["logged"])||!$_SESSION["logged"]){
						include 'inc/login.php';
					} else{
                  echo '<meta http-equiv="refresh" content="0; URL=intern.php?p=profile&uid='.$_SESSION["PKID"].'" />';
					}
				}elseif($_GET["p"]=="logout"){
					session_destroy();
                if(isset($_COOKIE["username"])){
                  forgetLogin();
                }
					echo '<meta http-equiv="refresh" content="0; URL=index.php" />';
				
				}elseif($_GET["p"]=="register"){
					if(isset($_SESSION["logged"])&&$_SESSION["logged"]){
						echo "<h1>Sie sind schon registriert</h1>";
					}elseif(!isset($_POST["submit"])||!checkusername()||!checkname()||!checkemail()||!checkpass()||!checksecquest($_POST["questnumb"])){
						include 'inc/register.php';							
					}else{
						echo "<h1>Registrieren erfolgreich!</h1>";
						newuser();
						$_SESSION["logged"]=TRUE;
						?>
							<meta http-equiv="refresh" content="0; URL=intern.php?p=profile&uid=<?PHP echo $_SESSION['PKID']; ?>" />
						<?PHP
					}
				}elseif($_GET["p"]=="profile"){
					include 'inc/profile.php';
				}elseif($_GET["p"]=="message"){
					include 'inc/messages.php';
				}else{
					echo "Keine Ahnung, was hier passieren soll^^!";
				}
            
            include_once 'inc/footer.html';
			?>
			</div>
		</body>
	</html>