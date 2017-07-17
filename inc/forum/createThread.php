
         <script type="text/javascript" src="js/createThread.js"></script>
         <link rel="stylesheet" type="text/css" href="trix/trix.css">
         <script type="text/javascript" src="trix/trix.js"></script>
         
         <?PHP
            if(isset($_SESSION['logged'])){
            $admin = false;
            $usergroup = SQLQuery1("SELECT * FROM user WHERE PKID = ?", $_SESSION['PKID']);
               if($usergroup['usergroup'] == 'admin'){
                  $admin=true;
               }
         ?>
         <div class="row">
            <h2>Thread erstellen</h2>
         </div>
         <?PHP
            if($admin == true){
         ?>
         <div class="row">
               <h3>Thread als Men&uuml;punkt oder f&uuml;r Threads?</h3>
               <label class="radio-inline"><input type="radio" name="thread" value="thread"> Thread </label>
               <label class="radio-inline"><input type="radio" name="thread" value="menupoint" id="menupoint"> Men&uuml;punkt </label>
         </div>
         <?PHP
         }
         ?>
         <div class="row">
            <div class="input-group margin-bottom">
               <span class="input-group-addon">Threadtitel</span>
               <input type="text" class="form-control" id="threadtitle" placeholder="" aria-describedby="threadtitle">
            </div>
         </div>
         <div class="row" id="trixdiv">
               <trix-editor id="trix"></trix-editor>
         </div>
         
         <div class="row">
            <a class ="btn btn-default btn-textfield pull-right" id="target"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>
         </div>
         
         <?PHP
         }else {
            echo '<h1> Melde dich an um Beitr&auml;ge zu verfassen</h1>';
         }
         ?>
         <?php
            include_once('inc/footer.html');
         ?>



     <script>
         
});     
     </script>