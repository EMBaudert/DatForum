
<?php
   if(isset($_SESSION['PKID'])){
      $user = SQLQuery1("SELECT * FROM user WHERE PKID_user= ?", $_SESSION['PKID']);
         if($user['usergroup']== 'admin' || $user['usergroup']== 'moderator' ){
            createReportsOverview();
         }else{
            echo '<h2>Error: Permission denied</h2>';
         }
   }else{
      echo '<h2>Error: You need to be logged in</2>';
   }
?>

<script>
   $(document).ready(function(){
      $('#solved').button().click(function(){
         if (confirm('Erledigt?')) {
              var query1part = "UPDATE `reports` SET `done` = 1, `doneby` = '"; 
              var query2part = "' WHERE `reports`.`PKID_report` = 1 ";
              var sql = {
                  type: 'reportdone',
                  query1: query1part,
                  query2: query2part
               }
               
               $.post("func/insertSQL.php",sql, function(result){
               
               });
               
              }
         
      });            
   });
</script>

