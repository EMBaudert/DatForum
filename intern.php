<!DOCTYPE html>
<?PHP
session_start();
include 'func/phpfunc.php';
?>
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
				<div id="loginbox"><a style="color:white;" href=<?PHP if(isset($_SESSION["logged"])&&$_SESSION["logged"]){ ?>"intern.php?p=logout">Logout<?PHP } else{ ?>"intern.php?p=login">Login<?PHP } ?></a>  &nbsp; <a style="color:white;" href="intern.php?p=register">Registrieren</a>  &nbsp;</div>
			</div>
			<div id="content">
			<?PHP
				if(!isset($_GET["p"])){
					echo "Keine bekannte Seite!";
				}elseif($_GET["p"]=="login"){
					if(isset($_POST["password"])&&checklogin($_POST["username"],hash('sha512',$_POST["password"]))){
						$_SESSION["logged"]=TRUE;
						?>
							<meta http-equiv="refresh" content="0; URL=index.php" />
						<?PHP
					}
					if(!isset($_SESSION["logged"])||!$_SESSION["logged"]){
						include 'inc/login.php';
					} else{
						echo "<h1>angemeldet</h1>";	#Profil anzeigen
					}
				}elseif($_GET["p"]=="logout"){
					session_destroy();
					?>
						<meta http-equiv="refresh" content="0; URL=index.php" />
					<?PHP
				}elseif($_GET["p"]=="register"){
					if(isset($_SESSION["logged"])&&$_SESSION["logged"]){
						echo "<h1>Sie sind schon registriert</h1>";
					}elseif(!isset($_POST["password"])||$_POST["password"]!=$_POST["password2"]||!checkusername()||!checkemail()||!checkpass()){
						if(isset($_SESSION["active"])){
							if(isset($_POST["firstname"])){
								$_SESSION["firstname"]=$_POST["firstname"];	
							}else{
								echo "<p>Kein Vorname eingegeben!</p>";
							}
							if(isset($_POST["secondname"])){
								$_SESSION["secondname"]=$_POST["secondname"];	
							}else{
								echo "<p>Kein Nachname eingegeben!</p>";
							}
							if(isset($_POST["username"])&&checkusername()){
								$_SESSION["username"]=$_POST["username"];	
							}
							if(isset($_POST["email"])&&checkemail()){
								$_SESSION["email"]=$_POST["email"];	
							}
							if(isset($_POST["password"])&&$_POST["password"]!=$_POST["password2"]){
								echo "<p>Die eingegebenen Passwörter stimmen nicht überein!</p>";
							}
							
							include 'inc/register.php';
						} else{
							include 'inc/register.php';
							$_SESSION["active"]=TRUE;
							
						}
					}else{
						echo "Registrieren erfolgreich!"; #Hier geht es dann weiter(Daten eintragen und so)
						$_SESSION["logged"]=TRUE;
						?>
							<meta http-equiv="refresh" content="0; URL=index.php" />
						<?PHP
						newuser();
					}
				}else{
					echo "Keine Ahnung, was hier passieren soll^^!";
				}
			?>
			</div>
			<div id="bottombar">Copy &copy; und so</div>
		</body>
	</html>