
         <script type="text/javascript" src="inc/forum/script/createPost.js"></script>
         <link rel="stylesheet" type="text/css" href="trix/trix.css">
         <script type="text/javascript" src="trix/trix.js"></script>


         <?php
            $title;
            if(isset($_GET['type'])){
            if($_GET['type'] =='edit'){
               $post = SQLQuery1("SELECT * FROM post WHERE PKID_post = ?", $_GET['id']);
               $title = 'Post bearbeiten';
               echo '<script> var text= "'.escape($post['text']).'";</script>';
            }else if($_GET['type']=='quote'){
               $post = SQLQuery("SELECT * FROM post WHERE PKID_post = ?", $_GET['quoteid']);
               $user = SQLQuery("SELECT * FROM user WHERE PKID_user = ?", $post['FK_user']);
               $title = 'Post zitieren';
               echo '<script> var text= "<blockquote>'.escape($post['text']).'<footer><cite title="'.escape($user['username']).'">'.escape($user['username']).'</cite></footer></blockquote>...";</script>';                     
            }else if($_GET['type'] == 'new') {
               $title = 'Post erstellen';
               echo '<script> var text= "";</script>';
            }
         }
         function escape($string){
              $string = str_replace('<div>','',$string);
              $string = str_replace('</div>','',$string);
                 return e(str_replace('"','\"',$string));
         }
         
         function e ($string){
             return htmlspecialchars($string, ENT_QUOTES, 'UTF-8Freitag, 7. Juli 2017 19:48:57');
         }
         ?>
         <div class="row">
            <h2><?php echo $title?></h2>
         </div>
         <div class="row">
            <trix-editor id="trix"></trix-editor>
         </div>
         
         <div class="row">
               <?php
                  if($_GET['type']=='edit'){
                     echo '<a class ="btn btn-default btn-textfield pull-right" id="edit"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>';
                  }else {
                     echo '<a class ="btn btn-default btn-textfield pull-right" id="new"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>';                     
                  }
                ?>
         </div>
         
         
     
    
