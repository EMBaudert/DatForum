<?php


/* Erstallt den rahmen für die posts und lässt jeden Post erstellen */
   function createPostOverview(){
      global $pdo;
      
      echo '<div class="row"><ul class="list-group">';
   
   /*$i benötigt für pagination, dass nur die Beiträge der richtigen Seite angezeigt werden
      $j benötigt als id für jeden post der angezeigt wird --> wird deshalb im if erhöht*/
      $i=0;
      $j=0;
      
      $statement = $pdo->prepare("SELECT * FROM post WHERE FK_thread = ?");
      $statement->execute(array('0' => $_GET['thread']));
      
      while ($row = $statement->fetch()) {
                
          // Wenn der Post innerhalb des Bereiches ist der angezeigt wird, wird createPost aufgerufen  
         if($i>= (($_GET['page']-1)*MAX_ENTRY_NUMBER)&& $i< ($_GET['page']*MAX_ENTRY_NUMBER)){
                      
            createPost($row,$j);
            $j++;
         }
         $i++;            
      }
                  
      echo '</ul></div>';
   }    
      
/* Erstellt einen einzelnen Post */
   function createPost($post, $j){
         
      $user = SQLQuery1("SELECT * FROM user WHERE PKID_user = ?", $post['FK_user']);
      $title = SQLQuery1("SELECT theme FROM thread WHERE PKID_thread = ?", $post['FK_thread']);

/* einzelner post */
      
echo  '<div class="panel panel-primary" id="'.$post['PKID_post'].'">
      
<!-- Panel header with date and time of creation -->
         <div class="panel-heading">
            '.$post['date'].' '.$post['time'].'
         </div>
<!-- Inhalt des Posts -->
         <div class="row equal">
      
<!-- Userinfo, zeigt links (bzw auf xs, sm oben) Username, Usergruppe + Profilbild. Zusätzlich  Knopf um direkt nachrichten schicken zu können-->
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 post-userinfo ">
            
<!-- Anzeige auf md  und lg, Alles untereinander, nospace für keinen Abstand -->
               <div class="hidden-xs hidden-sm nospace">
                  <p><a href="intern.php?p=profile&uid='.$post['FK_user'].'">'.$user['username'].'</a><br>' 
                     .$user['usergroup'].
                  '</p>';
                  if(isset($_SESSION['PKID']) && $_SESSION['PKID'] != $user['PKID_user']){
                     echo '<a class="btn btn-default btn-xs margin-bot" href="intern.php?p=message&cp='.$user['PKID_user'].'"><span class="glyphicon glyphicon-envelope"></span> Nachricht</a>';
                  }
                  echo '<img alt="Profilbild von '.$user['username'].'" src="'.$user['pb_path'].'" id="image'.$j.'" class="profile-picture">
               </div>
               
<!-- Anzeige für sm und xs, Name, gruppe und Nachrichten links, rechts das Bild -->
               <div class="hidden-md hidden-lg nospace">
                  <div class="col-xs-6 nospace">
                     <p><a href="intern.php?p=profile&uid='.$post['FK_user'].'">'.$user['username'].'</a><br>'
                  	  .$user['usergroup'].
                     '</p>';
                     if(isset($_SESSION['PKID']) && $_SESSION['PKID'] != $user['PKID_user']){
                echo '<a style="margin-bottom: 5px" class="btn btn-default btn-xs" href="intern.php?p=message&cp='.$user['PKID_user'].'"><span class="glyphicon glyphicon-envelope"></span> Nachricht</a>';
                     }
            echo '</div>
                  <div class="col-xs-6 ">
                     <img alt="Profilbild von '.$user['username'].'" src="'.$user['pb_path'].'" class="profile-picture">
                  </div>
               </div>
            </div>
            
<!-- Zeigt Inhalt des Posts, aufgeteilt in Überschrift, Inhalt und Signatur -->
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 post-content">
               <div class="row">
                  <p><b>'.$title['theme'].'</b></p>
               </div>
                  <hr class="hr-postcontent-top">
               
<!-- id wird benötigt da jeder contentdiv eine individuelle min-height bekommt -->
               <div id="div'.$j.'" class="row minheight">
                  '.$post['text'].'
               </div>
                  <hr class="hr-postcontent-bot">
               <div class="row" style="margin-top: 10px">
                  <p>'.$user['signature'].'</p>
               </diV>
            </div>
         </div>
            			
      <!-- Zeigt den footer an, der Buttons zur interaktion beinhaltet -->
         <div class="panel-footer ">
            <div class="row">';
               echo '<div class="btn-group pull-right" role="group">';
						   
      /* buttons werden generell nur angezeigt wenn man angemeldet ist */
					 if(isset($_SESSION["PKID"])){
      /* Wenn der Beitrag vom angemeldeten nutzer ist, kann er dn Text editieren */
                  $usergroup = SQLQuery1("SELECT * FROM user WHERE PKID_user = ?", $_SESSION['PKID']);
					    if($user['PKID_user'] == $_SESSION["PKID"]){
                     echo  '<a class ="btn btn-default" href="forum.php?p=createPost&type=edit&id='.$post['PKID_post'].'&creator='.$_SESSION['PKID'].'"><span class="glyphicon glyphicon-edit"></span> Edit</a>';	
                   }
      /* Wenn der Nutzer Moderator oder admin ist kann er einene Beitrag direkt löschen, ansonsten kann der Beitrag gemeldet werden */
                   if($usergroup['usergroup']=='admin' || $usergroup['usergroup']== 'moderator'){
                     echo '<a class ="btn btn-default delete" id="'.$post['PKID_post'].'"><span class="glyphicon glyphicon-edit"></span> L&ouml;schen</a>';
                   }else {
                     echo  '<a class ="btn btn-default report" id="'.$post['PKID_post'].'" creator="'.$_SESSION['PKID'].'"><span class="glyphicon glyphicon-edit"></span> Melden</a>';
                   }
      /* Button zum zitieren des beitrags*/
                   echo '<a class ="btn btn-default" href="forum.php?p=createPost&type=quote&id='.$_GET['thread'].'&quoteid='.$post['PKID_post'].'&creator='.$_SESSION['PKID'].'"><span class="glyphicon glyphicon-bullhorn"></span> Zitieren</a>';
               }
					    
               echo '</div>
            </div>
         </div>
         </div>';

         }

/* erstellt die Titel des Threads, Button für eine neue Antwort und die Pagination */
   function create2ndRow(){
      global $pdo;
         
      $title = SQLQuery1("SELECT theme FROM thread WHERE PKID_thread = ?", $_GET['thread']);
         
   /* einzelne row mit eigenem nargin um alles gleich zu halten*/
      echo '<div class="row marg-tb-5">
      
      <!-- Zeigt titel an, bei xs, sm eigene Zeile -->
         <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <h3>'.$title['theme'].'</h3>
         </div>
         
      <!-- Zeigt Button für neuen thread nur wenn man angemeldet ist  -->
         <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">';
         if(isset($_SESSION['logged'])){
      echo '<a class="btn-default" href="forum.php?p=createPost&type=new&id='.$_GET['thread'].'&creator='.$_SESSION['PKID'].'">
               <div type="button" class="btn btn-default">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Neuer Beitrag
               </div>
            </a>';
         }
   echo ' </div>
         <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">'; 
            createPagination();
         echo '</div>
            </div>';
               
   }
      
/* Erstellt die gesamte Pagination */
   function createPagination(){
         
   //getPagenumber
      $pageNumber = SQLQuery1("SELECT COUNT(PKID_post) as cnt FROM post WHERE FK_thread = ?", $_GET['thread']); 
        
   //berechnet benötigte seitenanzahl. Teilt alle Beiträge durch die festgelegte Maximalanzahl
      $pa = ceil($pageNumber['cnt'] / MAX_ENTRY_NUMBER);
   
    echo '<nav aria-label="pagination">
      <ul class="pagination pull-right">';     
   //button: Vorherige Seite. Ist bei Seite 1 deaktiviert
      if($_GET['page'] == 1){
         echo '<li class="disabled"><a href=""><span aria-hidden="true">&laquo;</span></a></li>';
      }else{
         echo '<li><a href="forum.php?p=thread&thread='.$_GET['thread'].'&page='.($_GET['page']-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
      }
      
   //Wenn die Maximale Seitenanzahl 0 ergibt, soll trotzdem die Pagination mit einer Seite angezeigt werden.
      if($pa == 0){
         echo '<li class="active"><a href="forum.php?p=thread&thread='.$_GET['thread'].'&page=1">1</a></li>';   
      }

   /*bei mehr als 5 einträgen wird der erste Beitrag und der letze Beitrag immer angezeigt.
         Die zwischen drin variieren je nach Seitenzahl:
   */
      if($pa > 5){
         createSingleMenuPoint(1);
   /* Bei Seite 1 oder 2 werden noch die Seiten 2-4 angezeigt sodass insgesamt 5 zellen angezeigt werden */
         if($_GET['page'] == 1||$_GET['page'] == 2){
            createSingleMenuPoint(2);
            createSingleMenuPoint(3);
            createSingleMenuPoint(4);  
   /* Bei der letzten oder vorletzten Seite werden die 4 letzten Seiten angezeigz, dass insgesamt 5 Zellen angezeigt werden */
         }else if($_GET['page'] == $pa-1||$_GET['page'] == $pa){
            createSingleMenuPoint($pa-3);
            createSingleMenuPoint($pa-2);
            createSingleMenuPoint($pa-1);
   /* Bei einer Zahl zwischendrin wird die aktuelle Seite sowie die vorherige und nachfoglende angezeigt */
         }else{
            createSingleMenuPoint($_GET['page']-1);
            createSingleMenuPoint($_GET['page']);
            createSingleMenuPoint($_GET['page']+1);
         }

         createSingleMenuPoint($pa);
               
      }else{
   /* bei weniger als 5 Seiten werden alle angezeigt */
         for($i=1;$i<$pa+1; $i++){
            createSingleMenuPoint($i);
         }
      }
            
   //Nächste Seite button, wird bei der letzten Seite deaktiviert
      if($_GET['page'] == ceil($pa) || $pa == 0){
         echo '<li class="disabled"><span aria-hidden="true">&raquo;</span></li>';
      }else{
         echo '<li><a href="forum.php?p=thread&thread='.$_GET['thread'].'&page='.($_GET['page']+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
      }
         
      echo '</ul></nav>';
         
      }
   
/* erstellt einzelnen Menuepunkt, bekommt die entsprechende Nummer übergeben */   
   function createSingleMenuPoint($nr){
      /* wenn die Seite aktiv ist, bekommt sie die entsprechende Klasse */
       if($_GET['page']==$nr){
          echo '<li class="active"><a href="forum.php?p=thread&thread='.$_GET['thread'].'&page='.$nr.'">'.$nr.'</a></li>';   
       }else{
          echo '<li><a href="forum.php?p=thread&thread='.$_GET['thread'].'&page='.$nr.'">'.$nr.'</a></li>';   
       }
   }
      
/* Erstellt Breadcrumbansicht für eine Übersicht des threadpfades */
   function createBreadcrumb($id){
   
   /* die function gibt das Mainmenu sowie die hauptstruktur, beginnt dann allerdings sich rekursiv aufzubauen, bis zum Menuepunkt vor dem aktuellen */
    echo '<div class="row"><ol class="breadcrumb">
    <li><a href="forum.php?p=menu&menu=0&page=1">Main menu</a></li>';
    recursiveBreadCrumb($id);
    $title = SQLQuery1("SELECT theme FROM thread WHERE PKID_thread = ?", $_GET['thread']);
    echo '<li class="active">'.$title['theme'].'</li>
      </ol></div>';

 }
 
/* Erstellt rekursiv das Breadcrumb menu, $id ist dabei die ID des vorletzten Elements */
   function recursiveBreadCrumb($id){

   /* Die Funktion ruft sich selbst bis zum Hauptmenüpunkt auf, danach werden alle Menüpunkte vom hauptmenü aus angezeigt
      Implementierung war so am einfachsten da ansonsten zuvor der komplette Pfad berechnet werden müsste.
   */
      $tempQuery = SQLQuery1("SELECT PKID_menu, title, FK_menu FROM menu WHERE PKID_menu = ?", $id);

//wenn kein Überpunkt mehr existiert kann aufgehört werden
      if($tempQuery['FK_menu']==NULL){
         echo '<li><a href="forum.php?p=menu&menu='.$tempQuery['PKID_menu'].'&page=1">'.$tempQuery['title'].'</a></li>';
         return;
      }
      
      recursiveBreadCrumb($tempQuery['FK_menu']);
   //nach dem obersten Menüpunkt wird nun vom Hauptmenü aus der Pfad immer weiter dargestellt
      echo '<li><a href="forum.php?p=menu&menu='.$tempQuery['PKID_menu'].'&page=1">'.$tempQuery['title'].'</a></li>';

   }
   
/* stellt das Thema des Threads dar */      
   function createThema(){

      $title = SQLQuery1("SELECT theme FROM thread WHERE PKID_thread = ?", $_GET['thread']);

      echo "<h3>".$title['theme']."</h3>";
 }
  
/* gibt die letzte Seite zurück, benötigt wenn thread.php ohne page parameter aufgerufen wird.
Dies passiert nur wenn ein neuer Beitrag verfasst wurde da dessen ID unbekant ist. Der letzte Beitrag wird aber immer 
auf der letzten Seite dargestellt. 
*/       
   function getLastPage(){
      $pageNumber = SQLQuery1("SELECT COUNT(PKID_post) as cnt FROM post WHERE FK_thread = ?", $_GET['thread']);
      return ceil($pageNumber['cnt'] / MAX_ENTRY_NUMBER);  
   }       


?>

