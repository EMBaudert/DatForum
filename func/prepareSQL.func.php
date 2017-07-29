<?PHP
   function SQLQuery0($query){
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
      
      $statement = $pdo->prepare($query);
      $statement->execute();   
      
      return $statement->fetch();
               
   }
   
   function SQLQuery1($query, $p0){
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
      $statement = $pdo->prepare($query);
      $statement->execute(array('0' => $p0));   
      
      return $statement->fetch();
               
   }
   
   function SQLQuery2($query, $p0, $p1){
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
      
      $statement = $pdo->prepare($query);
      $statement->execute(array('0' => $p0, '1' => $p1));   
      
      return $statement->fetch();
               
   }
   
   function SQLQuery3($query, $p0, $p1, $p2){
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
      
      $statement = $pdo->prepare($query);
      $statement->execute(array('0' => $p0, '1' => $p1, '2' => $p2));   
      
      return $statement->fetch();
               
   }
   
   function SQLQuery4($query, $p0, $p1, $p2, $p3){
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
      
      $statement = $pdo->prepare($query);
      $statement->execute(array('0' => $p0, '1' => $p1, '2' => $p2, '3' => $p4));   
      
      return $statement->fetch();
               
   }
?>