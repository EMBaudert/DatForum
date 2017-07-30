<?php
   
   $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
   
   //if fängt spezialfälle ab ansonsten wird ganz normal die Query ausgefühtz
   if(isset($_POST['type'])){
      if($_POST['type']== 'newThread'){

         execute($_POST['sql']);
         $id = SQLQuery2("SELECT PKID_thread FROM thread WHERE theme= ? AND FK_creator= ? ",$_POST['theme'],$_POST['creator']);
         echo $id['PKID_thread'];
         
         
      }else if($_POST['type']== 'report'){
         
         execute($_POST['query1'].$_SESSION['PKID'].$_POST['query2']);
         
      }else if($_POST['type']== 'reportdone'){
         execute($_POST['query1'].$_SESSION['PKID'].$_POST['query2']);
      }
      
   }else{
      execute($_POST['sql']);
      echo "fertig";
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
      
      function SQLQuery2($query, $p0, $p1){
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', ''); 
                        
         $statement = $pdo->prepare($query);
         $statement->execute(array('0' => $p0, '1' => $p1));   
                        
         return $statement->fetch();
                                 
      }
      
      
   
?>