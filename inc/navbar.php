<?php

#In der Navbar werden neben den Navigationselementen auch wichtige Funktionen übernommen, die am Anfang eines Dokuments nötig sind
	
 session_start();
 require_once 'func/prepareSQL.func.php';
 require_once 'func/user.func.php';
 require_once 'func/message.func.php';
 if(!isset($_SESSION["logged"])){               #Dieser Block ist nur nötig, wenn man nciht angemeldet ist
   $retval=checkCookieLogin();                  #Schauen, ob der Login gespeichert wurde
   if($retval&&!isset($_SESSION["logged"])){    #Wenn Cookies vorhanden sind, aber nicht korrekt kombiniert sind, wurden die Cookies manipuliert, also wird eine Nachricht an den betroffenen Nutzer gesendet
      addMessage("SystemOfADoom",$_COOKIE["username"],"Jemand hat versucht, über COOKIE-Manipulation Ihren Account zu hacken, wir konnten dies jedoch erfolgreich verhindern!");
      forgetLogin();                            #Und danach die Cookies wieder gelöscht
   }
 }
 #Hier wird geprüft, ob der Nutzer sich anmelden will und ob die Daten korrekt sind
  if(isset($_GET["p"])&&$_GET["p"]=="login" && isset($_POST["password"])&&substr($error=checklogin($_POST["username"],hash('sha512',$_POST["password"])),0,1)!="0"){
						$_SESSION["logged"]=TRUE;
						if(isset($_POST["remember"])){ #Wenn der Login gespeichert werden soll, werden die Cookies gesetzt
                     rememberLogin($_POST["username"],substr(hash('sha512',$_POST["password"]),0,20));
		            }else if(isset($_COOKIE["UID"])){ #Sonst werden mögliche Cookies gelöscht
                     forgetLogin();
		            }
            }
?>
<!-- Da für unsere Seite Javascript benötigt wird, wird ein browser ohne Javascript nicht zugelassen: -->
<noscript>
  <META HTTP-EQUIV="Refresh" CONTENT="0;URL=errors/noJS.php">
</noscript>
      <div class="row">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
               <!-- für responsive, handy menu -->
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					  </button>
					  <a class="navbar-brand" href="forum.php?p=menu&menu=0&page=1">Forum</a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
							<li><a href="index.php">Home</a></li>
                  </ul>
						<ul class="nav navbar-nav navbar-right">
                  
                     <?php
                        const MAX_ENTRY_NUMBER = 2; 
                        $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
                        
                     // if logged in showuser infos, otherwise the log in an dregister
                     if(isset($_SESSION['logged'])&&$_SESSION['logged']==true){
                        $messages = SQLQuery1("SELECT unread_messages FROM user WHERE PKID_user= ?", $_SESSION['PKID']);
                        $reports = SQLQuery0("SELECT COUNT(PKID_report) as 'cnt' FROM reports WHERE done=0");
                        $usergroup = SQLQuery1("SELECt usergroup FROM user WHERE PKID_user= ?", $_SESSION['PKID']);
                        //drop down mit Profile, Posts und Messages
                        
                        if($usergroup['usergroup']=='admin' || $usergroup['usergroup']=='moderator'){
                           echo '<li>
                                    <a href="intern.php?p=reports">Reports <span class="badge">'.$reports['cnt'].'</span></a> 
                                 </li>';
                        }
                        
                        echo '<li class="dropdown">
      						   <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                              <span class="glyphicon glyphicon-user"></span> Profile <span class="caret"></span>
                           </a>
      							<ul class="dropdown-menu">
         						   <li><a href="intern.php?p=profile&uid='.$_SESSION['PKID'].'">Profile</a></li>
                              <li><a href="intern.php?p=message">Messages ';
                              //Wenn ungelesene nachrichten vorhanden sind iwrd die anzahl angezeigt
                              echo '<span id="menuMessages">';
                              if ($messages['unread_messages']>0){
                                 echo '<span class="badge">'.$messages['unread_messages'].'</span>';
                              }
                              echo '
                              </span>
                              </a></li>
                           </ul>
   						   </li>
                        <li>
                           <a href="intern.php?p=logout"><span class="glyphicon glyphicon-log-out"></span> Logout </a>
                        </li>';

                     }else{
                     //wenn niemand angemeldet ist dropdowns in dennen registrations und anmeldeformulare sind
   						echo '<li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-plus-sign"></span> Register </a>
                              <ul class="dropdown-menu">
   									   <li class="dropdown-light">';
                           include 'inc/intern/register.php';
                           echo '</li>
   								    </ul>
                           </li>
                           <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-log-in"></span> Login </a>
                                 <ul class="dropdown-menu">
   									      <li class="dropdown-light">';
                           include 'inc/intern/login.php';
                              echo '</li>
   								       </ul>
   							     </li>';
                     }
                     
                     
                     
                     ?>
						</ul>
                  <!-- Searchbar -->
						<form class="navbar-form navbar-left" action="forum.php?p=search&page=1" method="GET">
							<div class="input-group">
   								<input type="text" class="form-control" name="search" placeholder="Search">
								<div class="input-group-btn">
									<button class="btn btn-default" type="submit">
										<i class="glyphicon glyphicon-search"></i>
									</button>
                           <input type="hidden" name="p" value="search">
                           <input type="hidden" name="page" value="1">
								</div>
							</div>
						</form>
					</div>
			  </div>
			</nav>
      </div>
	  
	  <?PHP
     if(!isset($_GET["p"])||($_GET["p"]!="login"&&$_GET["p"]!="register"&&$_GET["p"]!="logout")){
         $_SESSION["url"]= $_SERVER["PHP_SELF"];
        foreach($_GET as $key=>$val){
        if(!isset($vars)){
            $vars=0;
            $_SESSION["url"] .="?";
        }else{
            $_SESSION["url"] .="&";
        }
         $_SESSION["url"] .= $key."=".$val;
        }
     }
     if(isset($error)){
      echo substr($error,1);
     }
     ?>