<?php
   if(isset($_POST["SQLstatement"])){
      $sql = $_POST["SQLstatement"];
      $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
     	$statement = $pdo->prepare($sql);
     	$statement->execute();   
   }
?>