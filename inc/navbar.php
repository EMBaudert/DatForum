<?php	
 session_start(); 
//$_SESSION['logged'] = true;
//$_SESSION['PKID'] = 1;
?>

			<nav class="navbar navbar-inverted">
				<div class="container-fluid">
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					  </button>
					  <a class="navbar-brand" href="menu.php?menu=0&page=1">Forum</a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
							<li class="active"><a href="#">Home</a></li>
                  </ul>
						<ul class="nav navbar-nav navbar-right">
                  
                     <?php
                     if(isset($_SESSION['logged'])&&$_SESSION['logged']==true){
                        echo "<li class=\"dropdown\">
   								<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"intern.php?p=profile&uid=\"".$_SESSION['PKID'].
                           "\"><span class=\"glyphicon glyphicon-user\"></span> Profile <span class=\"caret\"></span></a>
   								<ul class=\"dropdown-menu\">
   									<li><a href=\"#\">Profile</a></li>
   									<li><a href=\"#\">Posts</a></li>
   								</ul>
   							</li>
                        <li><a href=\"intern.php?p=logout\"><span class=\"glyphicon glyphicon-log-out\"></span> Logout </a></li>";
                     }else{
   							echo "<li class=\"dropdown\">
   								<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><span class=\"glyphicon glyphicon-plus-sign\"></span> Register <span class=\"caret\"></span></a>
   								<ul class=\"dropdown-menu\">
   									<li>";
                        include 'inc/register.php';
                        echo "</li>
   								</ul>
   							</li>
   							<li class=\"dropdown\">
   								<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><span class=\"glyphicon glyphicon-log-in\"></span> Login <span class=\"caret\"></span></a>
   								<ul class=\"dropdown-menu\">
   									<li>";
                        include 'inc/login.php';
                        echo "</li>
   								</ul>
   							</li>";
                     }
                     ?>
						</ul>
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
	  
	  