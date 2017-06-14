<?PHP
session_start();
?>
<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>DatForum - Startseite</title>
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
			<h1>Startseite</h1>
         <h2><a href="intern.php?p=profile">Profil</a></h2>
			</div>
			
			<!--
			<div id="box1">1</div>
			<div id="box1">2</div>
			<div id="box2">3</div>
			<div id="box1" style="text-align:left;">4</div>
			<div id="box3">5</div>
			<div id="box4">6</div>
			<div id="box5">7</div>
			-->
			<div id="bottombar">Copy &copy; und so</div>
		</body>
	</html>