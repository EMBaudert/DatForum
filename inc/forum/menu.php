
   <?php
      require 'func/menu.func.php';
      
      //wenn kein menü gesetzt ist zum hauptmenü
      if(!isset($_GET['menu'])){
         $_GET['menu'] = "0";
      }
      //wenn keine seite gesetzt ist zur ersten seite
      if(!isset($_GET['page'])){
         $_GET['page'] = "1";
      }
      //Wenn last gesetzt ist zur letzten Seite springen (z.B. wenn ein neuer Beitrag verfasst wird. Dieser wird immer am ende angezeigt)
      if($_GET['page']=='last'){
         $_GET['page'] = getLastPage();
      }
      createBreadcrumb($_GET['menu']);
     
     
      //GET gets previous menu point, for main menu number is 0
      if($_GET['menu'] == "0"){
         $sqlString= "SELECT * FROM menu WHERE FK_menu IS NULL";
      }else{
         $sqlString = "SELECT * FROM menu WHERE FK_menu  = ".$_GET['menu'];
      }
      
      //Wenn thread true ist enthält der Menüpunkt threads, ansonsten menüpunkte, 
      //danach wird create2ndRow aufgerufen (1 für threads, 0 für menupoints), sowie die anderen funktionen, dann createThreadOverview()
      $checkThread = SQLQuery1("SELECT threads FROM menu WHERE PKID_menu = ?", $_GET['menu']);
      if($checkThread['threads']){
         create2ndRow(1);
         createThreadOverview($_GET['menu']);
         create2ndRow(1);
      }else {
         create2ndRow(0);
         createMenu($sqlString,$_GET['menu']);    
         create2ndRow(0);     
      }
   ?>