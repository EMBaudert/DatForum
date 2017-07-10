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
   <script src="bootstrap/jquery-3.2.1.min.js"></script>
   <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
	
   <head>
      <title>Threadansicht</title>
   </head>
   <body>
   
      <div class="container">
   
      <?php
         require 'inc/navbar.php';
      
   /* Wenn post gesetzt ist, soll die seite mit genau diesem post angezeigt werden.
      diese Seite wird berechnet durch die anzahl an Einträgen die vorher waren (erkennbar durch kleinere PKID).
      Die Anzahl geteilt durch die maximale anzahl an Beiträgen + ien kleiner Zusatz (um geraden zahlen zu entgehen)
      ergibt die Zahl der Seite*/
         if(isset($_GET['post'])){
            $postNumber = SQLQuery2("SELECT COUNT(PKID_post) as cnt FROM post WHERE FK_thread = 0 AND PKID_post < 1",$_GET['thread'],$_GET['post']); 
            $_GET['page'] = ceil(($postNumber['cnt']/ MAX_ENTRY_NUMBER)+0.00001);
            
         }else if(!isset($_GET['page'])){
   /*Wenn page nicht gesetzt ist gehe auf letzte Seite
   nötig da thread.php ohne page attribut nur aufgerufen wird wenn ein neuer Post verfasst wurde
   -> man will dnach seinen eigenen Post sehen*/
            $_GET['page'] = getLastPage();
         } 
         
         if(!isset($_GET['thread'])){      
//Wenn id des Threads nicht gesetzt ist, gehe zurück auf index.php
            echo "<meta http-equiv=\"refresh\" content=\"0; URL=index.php\" />";
         }
         
         
         //bekeomme id des Menues fuer Breadcrum
         $thread = SQLQuery1("SELECT FK_menu FROM thread WHERE PKID_thread = ?", $_GET['thread']);
         $menupoint = SQLQuery1("SELECT * FROM menu WHERE PKID_menu = ?", $thread['FK_menu']);
         
         
         
         //Breadcrumb menu mit dier darüberliegenden Menüstruktut
         createBreadcrumb($thread['FK_menu']);
         //2nd row zeigt Titel des Threads, Button für neuen post und pagination
         create2ndRow();
         createPostOverview();
         create2ndRow();
         
         include_once('inc/footer.html');
      ?>
      
      </div>

      <script>
                 
         /* Damit die Signatur bei jedem Post am unteren Ende des divs ist, auch wenn der content wenig inhalt hat 
         for(var i = 0; i<$('.contentdiv').length; i++){
            var height = $('#image'+i).height();
            $('#div'+i).css("min-height", height+"px");
         }*/
      
         $(document).ready(function() {
         
         //Meldung an SQL wenn 
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
            
            
         });
      </script>
      
   </body>
</html>