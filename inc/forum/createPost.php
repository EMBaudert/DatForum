
         <script type="text/javascript" src="js/createPost.js"></script>

         <script src="ckeditor/ckeditor.js"></script>

         <!-- macht die rechte untere Ecke des editors eckig  -->
         <style>
            .cke{
               border-radius:4px 4px 0px 4px;
            }
         </style>
         

         <?php
         
         //Zum verfassen muss man angemeldet sein
         if(isset($_SESSION['PKID'])){
         
         //userid wird später noch benötigt, lässt sich so nicht so einfach abändern wie in der Browserzeile
          echo '<script> var user='.$_SESSION['PKID'].'</script>';
            $title;
            if(isset($_GET['type'])){
               if($_GET['type'] =='edit'){
                  echo '<div id="setTitle" class="hide">Post bearbeiten</div>';
                  $post = SQLQuery1("SELECT * FROM post WHERE PKID_post = ?", $_GET['id']);
                  $title = 'Post bearbeiten';
                  echo '<script> var text= `'.$post['text'].'`;</script>';
               }else if($_GET['type']=='quote'){
                  echo '<div id="setTitle" class="hide">Post erstellen</div>';
                  $post = SQLQuery1("SELECT * FROM post WHERE PKID_post = ?", $_GET['quoteid']);
                  $user = SQLQuery1("SELECT * FROM user WHERE PKID_user = ?", $post['FK_user']);
                  $title = 'Post zitieren';
                  echo '<script> var text= `<blockquote>'.escape($post['text']).'<footer><cite title="'.escape($user['username']).'">'.escape($user['username']).'</cite></footer></blockquote>...`;</script>';                     
               }else if($_GET['type'] == 'new') {
                  echo '<div id="setTitle" class="hide">Post erstellen</div>';
                  $title = 'Post erstellen';
                  echo '<script> var text= "";</script>';
               }
            }
          }else {
               echo '<row><h2>Bitte anmelden!</h2></row>';
            }
            //maskiert scripttags
            function escape($string){
                  $string = str_replace('<script>','CrossSiteScripting detected. Is blocked now!',$string);
                  return $string;
            }
            
            
         if(isset($_SESSION['PKID'])){ ?>
         <div class="row">
            <h2><?php echo $title?></h2>
         </div>
         
            <div class="row">
               <form>
                  <textarea name="editor1" id="editor1" rows="10" cols="80">
                      Error occured. Please relaod or enable javascript.
                  </textarea>
                  <script>
                      CKEDITOR.replace( 'editor1' );
                  </script>
               </form>
            </div>
            
            <div class="row placeholder">
                  <?php
                     if($_GET['type']=='edit'){
                        echo '<a class ="btn btn-default btn-textfield pull-right" id="edit"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>';
                     }else {
                        echo '<a class ="btn btn-default btn-textfield pull-right" id="new"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>';                     
                     }
                   ?>
            </div>
            
         <?php } ?>