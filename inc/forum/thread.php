  
      <?php
         require 'func/thread.func.php';
   /* Wenn post gesetzt ist, soll die seite mit genau diesem post angezeigt werden.
      diese Seite wird berechnet durch die anzahl an Eintr�gen die vorher waren (erkennbar durch kleinere PKID).
      Die Anzahl geteilt durch die maximale anzahl an Beitr�gen + ien kleiner Zusatz (um geraden zahlen zu entgehen)
      ergibt die Zahl der Seite*/
         if(isset($_GET['post'])){
            $postNumber = SQLQuery2("SELECT COUNT(PKID_post) as cnt FROM post WHERE FK_thread = 0 AND PKID_post < 1",$_GET['thread'],$_GET['post']); 
            $_GET['page'] = ceil(($postNumber['cnt']/ MAX_ENTRY_NUMBER)+0.00001);
            
         }else if(!isset($_GET['page'])){
   /*Wenn page nicht gesetzt ist gehe auf letzte Seite
   n�tig da thread.php ohne page attribut nur aufgerufen wird wenn ein neuer Post verfasst wurde
   -> man will dnach seinen eigenen Post sehen*/
            $_GET['page'] = getLastPage();
         } 
         
         if(!isset($_GET['thread'])){      
//Wenn id des Threads nicht gesetzt ist, gehe zur�ck auf index.php
            echo "<meta http-equiv=\"refresh\" content=\"0; URL=index.php\" />";
         }
         
         
         //bekeomme id des Menues fuer Breadcrum
         $thread = SQLQuery1("SELECT FK_menu FROM thread WHERE PKID_thread = ?", $_GET['thread']);
         $menupoint = SQLQuery1("SELECT * FROM menu WHERE PKID_menu = ?", $thread['FK_menu']);
         
         
         
         //Breadcrumb menu mit dier dar�berliegenden Men�struktut
         createBreadcrumb($thread['FK_menu']);
         //2nd row zeigt Titel des Threads, Button f�r neuen post und pagination
         create2ndRow();
         createPostOverview();
         create2ndRow();
         
      ?>