<?PHP
require_once 'func/menufunc.php';
require_once 'func/message.func.php';
?>
<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>DatForum - Startseite</title>
			<link rel="SHORTCUT ICON" href="layout/icon.ico" />
         <!-- Das neueste kompilierte und minimierte CSS -->
         <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

         <!-- Optionales Theme -->
         <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
         <link rel="stylesheet" href="layout/style.css">

         <!-- Latest compiled and minified JavaScript -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

         
		</head>
		<body>
       
        <div class="container">
        <?php
           require_once 'inc/navbar.php';
           $me=getMe();
           $other=getOther();
           if(isset($_POST["newMessage"])){
               $temp=addMessage($me,$other["username"],$_POST["newMessage"]);
           }
           $text=getMessages($me,$other["username"]);
         ?>
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Messages with <?PHP echo $other["username"]; ?>
                    
                </div>
                <div class="panel-body" id="scrollable_chat">
                    <ul class="chat">
                    <?PHP echo $text; ?>
                        
                    </ul>
                </div>
                <div class="panel-footer">
                        <form action="test_chat.php?cp=<?PHP echo $other["PKID"]; ?>" method="post">
                    <div class="input-group">
                        <input id="btn-input" type="text" name="newMessage" class="form-control input-sm" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" type="submit" id="btn-chat">
                                Send</button>
                        </span>
                      
                    </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
</div>

			<?php
           include_once 'inc/footer.html';
         ?>
       <script>
            var objDiv = document.getElementById("scrollable_chat");
            objDiv.scrollTop = objDiv.scrollHeight;
         </script> 
		</body>
	</html>