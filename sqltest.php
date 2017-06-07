<html>

   

   <head>
      <title>Forum</title>
   </head>
   
   <body>
   
   <?php
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      
      $sql = "SELECT * FROM user";
      
      foreach ($pdo->query($sql) as $row) {
         
         anzeigen($row['vorname'],$row['nachname'],$row['username']);

      }

      
      
      
      function anzeigen($vorname, $nachname, $username){
         echo "<h1>".$username."</h1>"."<br>";
         
         showLI($nachname, $username);
            
       
      }
      
      function showLI($args){
         $args = func_get_args();
         echo "<ul>";  
         foreach($args as $t){
            echo "<li>".$t."</li>";
         }
         echo "</ul>";  
         
      }
      
      
   ?>
   
   
   </body>