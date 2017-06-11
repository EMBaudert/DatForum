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
				<a href="index.php"><div id="toplogo"></div></a>
				<div id="search"></div> 
				<div id="loginbox"><a style="color:white;" href=<?PHP if(isset($_SESSION["logged"])&&$_SESSION["logged"]){ ?>"intern.php?p=logout">Logout<?PHP } else{ ?>"intern.php?p=login">Login</a>  &nbsp; <a style="color:white;" href="intern.php?p=register">Registrieren<?PHP } ?></a>  &nbsp;</div>
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
					}elseif(!isset($_POST["submit"])||!checkusername()||!checkname()||!checkemail()||!checkpass()){
						include 'inc/register.php';							
					}else{
						echo "<h1>Registrieren erfolgreich!</h1>"; #Hier geht es dann weiter(Daten eintragen und so)
						newuser();
						$_SESSION["logged"]=TRUE;
						?>
							<meta http-equiv="refresh" content="0; URL=index.php" />
						<?PHP
					}
				}else{
					echo "Keine Ahnung, was hier passieren soll^^!";
				}
			?>
			</div>
			<div id="bottombar">Copy &copy; und so</div>
		</body>
	</html>