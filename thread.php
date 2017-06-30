<?php
   require 'func/thread.func.php';
?>

<!DOCTYPE html>
<html>

   <!-- Das neueste kompilierte und minimierte CSS -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

   <!-- Optionales Theme -->
   <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">

   <!-- Latest compiled and minified JavaScript -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
	

   <head>
      <title>Thread</title>
   </head>
   <body>
   
      <div class="container">
   
      <?php
         require 'inc/navbar.php';
         //gibt an wieviele threads auf eine Seite dürfen
         const MAX_ENTRY_NUMBER = 2;
      
//Wenn id des Threads nicht gesetzt ist, gehe zurück auf index.php
         if(!isset($_GET['thread'])){
            echo "<meta http-equiv=\"refresh\" content=\"0; URL=index.php\" />";
         }
         //Wenn page nicht gesetzt ist gehe auf letzte Seite
         if(!isset($_GET['page'])){
            $_GET['page'] = getLastPage();
         }
         //bekeomme id des Menues fuer Breadcrum
         $thread = SQLQuery("SELECT FK_menu FROM thread WHERE PKID_thread = " .$_GET['thread']);
         $menupoint = SQLQuery("SELECT * FROM menu WHERE PKID_menu = " .$thread['FK_menu']);
      
         createBreadcrumb($thread['FK_menu']);
         create2ndRow();
         createPostOverview();
         create2ndRow();
         
      ?>
      
      <?php include_once('inc/footer.html'); ?>         
         
      </div>
      
      <script>
         $(document).ready(function() {
            $('#report').button().click(function(){
               var reason = prompt("Bitte Grund angeben: ", "");
               
               var queryPart1 = "INSERT INTO `reports` (`PKID_report`, `FK_user`, `reason`) VALUES (NULL, '";
               var queryPart2 = "', '"+reason+"')";
               
               var sql = {
                  type: 'report',
                  query1: queryPart1,
                  query2: queryPart2
               }
               
               $.post("func/insertSQL.php",sql);
               
            });
            
            $(".delete").click(
               function()
               {
                  var query = "DELETE FROM `post` WHERE `post`.`PKID_post` = "+$(this).attr("id");
                  alert(query);
                  var sql = {
                     sql: query
                  }
                  $.post("func/insertSQL.php",sql, function(result){
                     alert(result);
                  });;
            });
            
            
            /*function delete(id){
               alert(id);
            }*/
         });
      </script>
      
   </body>
</html>