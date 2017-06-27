<?php
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   if(isset($_POST['type'])){
      if($_POST['type']== 'newThread'){

         execute($_POST['sql']);
         $id = SQLQuery("SELECT PKID_thread FROM thread WHERE theme='".$_POST['theme']."' AND FK_creator=".$_POST['creator']);
         echo $id['PKID_thread'];
      }else{
         
      }
      
   }else{
      echo ($_POST['sql']);
      execute($_POST['sql']);
   }
      
      
     function execute($sql){
      global $pdo;
      	$statement = $pdo->prepare($sql);
      	$statement->execute();
      }
      
      function SQLQuery($query){

         global $pdo;
         $temp=$pdo->query($query);
         $temp->execute();
         return $temp->fetch();
      }
      
      
   
?>