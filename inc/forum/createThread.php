
         <script type="text/javascript" src="js/createThread.js"></script>
         <link rel="stylesheet" type="text/css" href="trix/trix.css">
         <script type="text/javascript" src="trix/trix.js"></script>
         
         <script src="ckeditor/ckeditor.js"></script>
         
         <?PHP
         echo "hey";
            if(isset($_SESSION['logged'])){
            $admin = false;
            $usergroup = SQLQuery1("SELECT * FROM user WHERE PKID = ?", $_SESSION['PKID']);
               if($usergroup['usergroup'] == 'admin'){
                  $admin=true;
               }
               echo "heyhey";
         ?>
         <div class="row">
            <h2>Thread erstellen</h2>
         </div>
         <?PHP
            if($_GET['type'] == 'menupoint'){ // &$admin == true){
               echo "drin";
         ?>
         <div class="row">
               <h3>Thread als Men&uuml;punkt oder f&uuml;r Threads?</h3>
               <label class="radio-inline"><input type="radio" name="thread" value="thread"> Thread </label>
               <label class="radio-inline"><input type="radio" name="thread" value="menupoint" id="menupoint"> Men&uuml;punkt </label>
         </div>
         <div class="row">
            <div class="input-group margin-bottom">
               <span class="input-group-addon">Men&uuml;titel</span>
               <input type="text" class="form-control" id="threadtitle" placeholder="" aria-describedby="threadtitle">
            </div>
         </div>
         <?PHP
            }else{
         ?>
         <div class="row">
            <div class="input-group margin-bottom">
               <span class="input-group-addon">Threadtitel</span>
               <input type="text" class="form-control" id="threadtitle" placeholder="" aria-describedby="threadtitle">
            </div>
         </div>
         <div class="row" id="ckdiv">
            <!-- <trix-editor id="trix"></trix-editor> -->
            <form>
               <textarea name="editor1" id="editor1" rows="10" cols="80">
                   This is my textarea to be replaced with CKEditor.
               </textarea>
               <script>
                   // Replace the <textarea id="editor1"> with a CKEditor
                   // instance, using default configuration.
                   CKEDITOR.replace( 'editor1' );
               </script>
            </form>
         </div>
         
         <div class="row">
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



     <script>
         
});     
     </script>