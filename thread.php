<html>

   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

   <!-- Das neueste kompilierte und minimierte JavaScript -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

   <head>
      <title>Thread</title>
   </head>
   <body>
   
      <div class="container">
   
      <?php
         const MAX_ENTRY_NUMBER = 1;
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
      
         createPostOverview();
      
         function createPostOverview(){
            global $pdo;
         
               //createPagination(0);
               
               echo "<div class=\"container\"><ul class=\"list-group\">";
               
               $i=0;
               foreach ($pdo->query("SELECT * FROM post WHERE FK_thread = ".$_GET['thread']) as $row) {
               
                  if($i>= ($_GET['page']-1*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
                   
                     createPost($row);
                  }
                  $i++;            
               }
         }
      
      
         function createPost($post){
         
            $user = SQLQuery("SELECT * FROM user WHERE PKID_user = ".$post['FK_user']);
            $title = SQLQuery("SELECT theme FROM thread WHERE PKID_thread = ".$post['FK_thread']);
            
            echo" <div class=\"container\">
 		
      			<div class=\"row\">
      				".$post['date']." ".$post['time']."
      			</div>
      			
      			<div class=\"row\">
      				<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3\">
      					<p>".$user['username']."</p>
      					<p>".$user['group']."</p>
      					<p>Bild</p>
      				
      				</div>
      				<div class=\"col-xs-12 col-sm-12 col-md-9 col-lg-9\">
      					<p><b>".$title['theme']."</b></p>
      					<hr>
      					<p>".$post['text']."</p>
      					<hr>
      					<p>".$user['signature']."</p>
      					
      					
      				</div>
      			</div>
      			
      			<div class=\"row\">
      				zitieren
      			</div>
      			
      			
      		</div>";
         }
         
         
         
         function SQLQuery($query){
            global $pdo;
            
            $temp=$pdo->query($query);
            $temp->execute();
            return $temp->fetch();
            
         }
      
      ?>
      
      </div>
   
   </body>
</html>