
         <?php
            require 'func/menu.func.php';
      
      
         if(!isset($_GET['menu'])){
            $_GET['menu'] = "0";
         }
         if(!isset($_GET['page'])){
            $_GET['page'] = "1";
         }
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
         //check if thread true, dann createThreadOverview()
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