<?php	
 session_start();
 require_once 'func/user.func.php';
 require_once 'func/message.func.php';
 if(!isset($_SESSION["logged"])){
   $retval=checkCookieLogin(); 
   if($retval&&!isset($_SESSION["logged"])){
      addMessage("SystemOfADoom",$_COOKIE["username"],"Jemand hat versucht, �ber COOKIE-Manipulation Ihren Account zu hacken, wir konnten dies jedoch erfolgreich verhindern!");
   }
 }
  if(isset($_GET["p"])&&$_GET["p"]=="login" && isset($_POST["password"])&&checklogin($_POST["username"],hash('sha512',$_POST["password"]))){
						$_SESSION["logged"]=TRUE;
						if(isset($_POST["remember"])){
                     rememberLogin($_POST["username"],substr(hash('sha512',$_POST["password"]),0,20));
		            }else if(isset($_COOKIE["UID"])){
                     forgetLogin();
		            }
            }
?>
      <div class="row">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
               <!-- f�r responsive, handy menu -->
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					  </button>
					  <a class="navbar-brand" href="menu.php?menu=0&page=1">Forum</a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
							<li><a href="index.php">Home</a></li>
                  </ul>
						<ul class="nav navbar-nav navbar-right">
                  
                     <?php
                     
                        $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
                        
                     // if logged in showuser infos, otherwise the log in an dregister
                     if(isset($_SESSION['logged'])&&$_SESSION['logged']==true){
                        $messages = SQLQuery("SELECT unread_messages FROM user WHERE PKID_user=".$_SESSION['PKID']);
                        $reports = SQLQuery("SELECT COUNT(PKID_report) as 'cnt' FROM reports WHERE done=0");
                        $usergroup = SQLQuery("SELECt usergroup FROM user WHERE PKID_user=".$_SESSION['PKID']);
                        //drop down mit Profile, Posts und Messages
                        
                        if($usergroup['usergroup']=='admin' || $usergroup['usergroup']=='moderator'){
                           echo '<li>
                                    <a href="reports.php">Reports <span class="badge">'.$reports['cnt'].'</span></a> 
                                 </li>';
                        }
                        
                        echo '<li class="dropdown">
      						   <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                              <span class="glyphicon glyphicon-user"></span> Profile <span class="caret"></span>
                           </a>
      							<ul class="dropdown-menu">
         						   <li><a href="intern.php?p=profile&uid='.$_SESSION['PKID'].'">Profile</a></li>
         							<li><a href="#">Posts</a></li>
                              <li><a href="intern.php?p=message">Messages ';
                              //Wenn ungelesene nachrichten vorhanden sind iwrd die anzahl angezeigt
                              echo '<span class="badge" id="menuMessages">';
                              if ($messages['unread_messages']>0){
                                 echo $messages['unread_messages'];
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
                           include 'inc/register.php';
                           echo '</li>
   								    </ul>
                           </li>
                           <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-log-in"></span> Login </a>
                                 <ul class="dropdown-menu">
   									      <li class="dropdown-light">';
                           include 'inc/login.php';
                              echo '</li>
   								       </ul>
   							     </li>';
                     }
                     
                     function SQLQuery($query){
                        global $pdo;
                        $temp=$pdo->query($query);
                        $temp->execute();
                        return $temp->fetch();
                                 
                     }
                     
                     
                     ?>
						</ul>
                  <!-- Searchbar -->
						<form class="navbar-form navbar-left">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search">
								<div class="input-group-btn">
									<button class="btn btn-default" type="submit">
										<i class="glyphicon glyphicon-search"></i>
									</button>
								</div>
							</div>
						</form>
					</div>
			  </div>
			</nav>
      </div>
	  
	  