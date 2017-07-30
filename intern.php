<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title id="pageTitle">DatForum</title>
			<link rel="SHORTCUT ICON" href="layout/favicon.ico" />
         <!-- Das neueste kompilierte und minimierte CSS -->
         <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

         <!-- Optionales Theme -->
         <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">

         <!-- Latest compiled and minified JavaScript -->
         <script src="bootstrap/jquery-3.2.1.min.js"></script>
         <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
      	<audio autoplay="true" loop="trueM" class="hide" controls>
            <source src="inc/backgroundsong.mp3" type="audio/mpeg">
         </audio>
		</head>
		<body> 
			<div class="container">
			<?php
           
require_once 'func/user.func.php';
require_once 'func/reports.func.php';
            require_once 'inc/navbar.php';
            
				if(!isset($_GET["p"])){
					echo '<div id="setTitle" class="hide">Interner Bereich</div>Keine bekannte Seite!';
				}elseif($_GET["p"]=="login"){
					if(!isset($_SESSION["logged"])||!$_SESSION["logged"]){
						include 'inc/intern/login.php';
                  echo '<script type="text/javascript">
                                    function setunabled(){
                                       $(".buttonlogin").prop("disabled",true);
                                       $(".buttonlogin").prop("title","Please wait!");
                                       $(".timeleft").html(5);
                                       var interv = setInterval(function(){
                                             temp = parseInt($(".timeleft").html());
                                             temp--;
                                             $(".timeleft").html(temp); 
                                             if(temp==0){
                                                clearInterval(interv);
                                                $(".timeleft").html(""); 
                                             }
                                          },1000); 
                                       setTimeout(function(){$(".buttonlogin").prop("disabled",false); $(".buttonlogin").prop("title","");},5000);
                                       
                                    }
                                    setunabled();
                        </script>';
					} else{
                  if(isset($_SESSION["url"])){
                     $link= $_SESSION["url"];
                  }else{
                     $link= 'intern.php?p=profile&uid='.$_SESSION["PKID"];
                  }
                  echo '<meta http-equiv="refresh" content="0; URL='.$link.'" />';
					}
				}elseif($_GET["p"]=="logout"){
               if(isset($_COOKIE["username"])){
                  forgetLogin();
               }
					if(isset($_SESSION["url"])){
                  $link= $_SESSION["url"];
               }else{
                  $link= 'intern.php?p=profile&uid='.$_SESSION["PKID"];
               }
					session_destroy();
               echo '<meta http-equiv="refresh" content="0; URL='.$link.'" />';
				
				}elseif($_GET["p"]=="register"){
					if(isset($_SESSION["logged"])&&$_SESSION["logged"]){
						echo "<h1>Sie sind schon registriert</h1>";
					}elseif(!isset($_POST["submit"])||!checkusername()||!checkname()||!checkemail()||!checkpass()||!checkdata()||!checksecquest($_POST["questnumb"])){
						include 'inc/intern/register.php';							
					}else{
						echo "<h1>Registrieren erfolgreich!</h1>";
						newuser();
						$_SESSION["logged"]=TRUE;
						if(isset($_SESSION["url"])){
                     $link= $_SESSION["url"];
                  }else{
                     $link= 'intern.php?p=profile&uid='.$_SESSION["PKID"];
                  }
                  echo '<meta http-equiv="refresh" content="0; URL='.$link.'" />';
					}
				}elseif($_GET["p"]=="profile"){
					include 'inc/intern/profile.php';
				}elseif($_GET["p"]=="message"){
					include 'inc/intern/messages.php';
				}elseif($_GET["p"]=="reports"){
					include 'inc/intern/reports.php';
				}else{
					echo '<div id="setTitle" class="hide">Interner Bereich</div>Keine Ahnung, was hier passieren soll^^!';
				}
            if(isset($_SESSION["PKID"])){
                  echo '<div id="refresh" style="text-align: center;"></div>';
            }
            include_once 'inc/footer.html';
			?>
			</div>
		</body>
	</html>