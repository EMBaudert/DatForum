
         <script type="text/javascript" src="js/createThread.js"></script>         
         <script src="ckeditor/ckeditor.js"></script
         <script type="text/javascript" src="js/createThread.js"></script>         
         
         <div id="setTitle" class="hide">Thread erstellen</div>
         
         
         <?PHP
            
         
            if(isset($_SESSION['logged'])){
            echo '<script>var userID = '.$_SESSION['PKID'].';</script>';
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
            //Wenn ein Menüpunkt hinzugefügt wird, das passende Formular anzeigen
               if($_GET['type'] == 'menupoint'){
                  ?>
                  <div class="row">
                        <h3>Men&uuml;punkt f&uuml;r weitere Men&uuml;punkte oder f&uuml;r Threads?</h3>
                        <label class="radio-inline"><input type="radio" name="thread" value="thread"> Thread </label>
                        <label class="radio-inline"><input type="radio" name="thread" value="menupoint" id="menupoint"> Men&uuml;punkt </label>
                  </div>
                  <div class="row inputfield">
                     <div class="input-group">
                        <span class="input-group-addon">Men&uuml;titel</span>
                        <input type="text" class="form-control" id="threadtitle" placeholder="" aria-describedby="threadtitle">
                     </div>
                  </div>
                  <div class="row margin-bottom">
                     <a class ="btn btn-default btn-textfield pull-right" id="addMenupoint"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>
                  </div>
                  <?PHP
            //Bei einem Thread der erstellt wird, Editor plus formfeld für titel
               }else{
                  ?>
                  <div class="row">
                     <div class="input-group margin-bottom">
                        <span class="input-group-addon">Threadtitel</span>
                        <input type="text" class="form-control" id="threadtitle" placeholder="" aria-describedby="threadtitle">
                     </div>
                  </div>
                  <div class="row">
                     <form>
                        <textarea name="editor1" id="editor1" rows="10" cols="80">
                        
                        </textarea>
                        <script>
                            CKEDITOR.replace( 'editor1' );
                        </script>
                     </form>
                  </div>
                  
                  <div class="row placeholder">
                     <a class ="btn btn-default btn-textfield pull-right" id="target"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>
                  </div>
                  
                  <?PHP
               }
         }else {
            echo '<h1> Melde dich an um Beitr&auml;ge zu verfassen</h1>';
         }
         ?>
         <?php
            include_once('inc/footer.html');
         ?>


