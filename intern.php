<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>DatForum - Intern</title>
			<link rel="SHORTCUT ICON" href="layout/icon.ico" />
			<link rel="stylesheet" type="text/css" href="layout/style.css" />
		</head>
		<body>
			<div id="topbar">
				<div id="toplogo"></div>
				<div id="search"></div>
				<div id="loginbox"><a href="intern.php?p=login">Login</a>  &nbsp; <a href="intern.php?p=register">Registrieren</a>  &nbsp;</div>
			</div>
			<div id="content">
			<?PHP
				if(!isset($_GET["p"])){
					echo "Keine bekannte Seite!";
				}elseif($_GET["p"]=="login"){
					if(!isset($_POST["password"])||$_POST["password"]!="testpass1"){
						include 'inc/login.txt';
					} else{
						echo "angemeldet";	#Profil anzeigen
					}
				}elseif($_GET["p"]=="register"){
					if(!isset($_POST["password"])||$_POST["password"]!=$_POST["password2"]){
						if(isset($_POST["password"])){
							echo "Passwörter stimmen nicht überein!";
						}
						include 'inc/register.txt';
					}else{
						echo "Registrieren erfolgreich!"; #Hier geht es dann weiter
					}
				}else{
					echo "Keine Ahnung, was hier passieren soll^^!";
				}
			?>
			</div>
			<div id="bottombar">Copy &copy; und so</div>
		</body>
	</html>