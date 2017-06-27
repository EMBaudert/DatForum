<?php	
 session_start();
?>
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
                     
                        //drop down mit Profile, Posts und Messages
                        echo '<li class="dropdown">
      						   <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                              <span class="glyphicon glyphicon-user"></span> Profile <span class="caret"></span>
                           </a>
      							<ul class="dropdown-menu">
         						   <li><a href="intern.php?p=profile&uid='.$_SESSION['PKID'].'">Profile</a></li>
         							<li><a href="#">Posts</a></li>
                              <li><a href="#">Messages ';
                              //Wenn ungelesene nachrichten vorhanden sind iwrd die anzahl angezeigt
                              if ($messages['unread_messages']>0){
                                 echo '<span class="badge">'.$messages['unread_messages'].'</span>';
                              }
                              echo '</a></li>
                           </ul>
   						   </li>
                        <li>
                           <a href="intern.php?p=logout"><span class="glyphicon glyphicon-log-out"></span> Logout </a>
                        </li>';

                     }else{
                     //wenn niemand angemeldet ist dropdowns in dennen registrations und anmeldeformulare sind
   						echo '<li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-plus-sign"></span> Register </span></a>
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
	  
	  