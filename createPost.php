<!DOCTYPE html>
<html>
   <head>
     <meta charset="UTF-8">
     <title>Post bearbeiten</title>
     
     <!-- Das neueste kompilierte und minimierte CSS -->
      <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

      <!-- Optionales Theme -->
      <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">

      <!-- Latest compiled and minified JavaScript -->
      <script src="bootstrap/jquery-3.2.1.min.js"></script>
      <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
     
     <link rel="stylesheet" type="text/css" href="trix/trix.css">
     <script type="text/javascript" src="trix/trix.js"></script>

     
   </head>

   <body>
      <div class="container">
      
         <?php
            require_once('inc/navbar.php');
            
            $title;
            if(isset($_GET['type'])){
            if($_GET['type'] =='edit'){
               $post = SQLQuery("SELECT * FROM post WHERE PKID_post =".$_GET['id']);
               $title = 'Post bearbeiten';
               echo '<script> var text= "'.escape($post['text']).'";</script>';
            }else if($_GET['type']=='quote'){
               $post = SQLQuery("SELECT * FROM post WHERE PKID_post =".$_GET['quoteid']);
               $user = SQLQuery("SELECT * FROM user WHERE PKID_user =".$post['FK_user']);
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
                 return str_replace('"','\"',$string);
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
                     echo '<a class ="btn btn-default btn-textfield" id="edit"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>';
                  }else {
                     echo '<a class ="btn btn-default btn-textfield" id="new"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>';                     
                  }
                ?>
         </div>
         
         <?php
            include_once('inc/footer.html');
         ?>
      </div>
     
      <script>
      
         
         document.addEventListener("trix-initialize", function(event) {
            var element = document.querySelector("trix-editor");
            element.editor.insertString(text);
          });
      
      
        $(document).ready(function() {
            var d = new Date();
            
            
            //Button für neuen Post
            $('#new').button().click(function(){
                  
                  var text = $('#trix').val();
            
                  //Einfügen in post wird erstellt
                  var query =  "INSERT INTO `post` (`PKID_post`, `FK_user`, `FK_thread`, `date`, `time`, `text`) VALUES (NULL, '"+getUrlVars()["creator"]+"', '"
                  +getUrlVars()["id"]+"', '"+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+"', '"+d.getHours()+"-"+d.getMinutes()+"-"+d.getSeconds()+"', '"+text+"');";
                  
                  //Post wird erstellt
                  var sql = {sql: query};
                  
                  //post wird aufgerufen
                  
                  $.post("func/insertSQL.php",sql);
                  
                  //update number of posts
                  var query = "UPDATE user SET numberposts = numberposts+1 WHERE PKID_user = "+getUrlVars()["creator"];
                  var sql2= {
                     sql:  query
                  };
                  $.post("func/insertSQL.php",sql2);
                  
                  
                  $("#trix").animate({"left":"+=100px"},function() {location.href = "thread.php?thread="+getUrlVars()["id"]});
             });   
             
             //Button für editieren 
             $('#edit').button().click(function(){
                 // Text wird gespeichert
                 var text = $('#trix').val();
                  var query = "UPDATE post SET text = '"+text+"' WHERE PKID_post = "+getUrlVars()["id"];
                  //Post wird erstellt
                  var sql = {sql: query};
                  //post wird aufgerufen
                  $.post("func/insertSQL.php",sql);
                  $("#trix").animate({"left":"+=100px"},function() {location.href = "thread.php?thread="+getUrlVars()["id"]});
             }); 
             
              function getUrlVars()
               {
                   var vars = [], hash;
                   var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                   for(var i = 0; i < hashes.length; i++)
                   {
                       hash = hashes[i].split('=');

                       if($.inArray(hash[0], vars)>-1)
                       {
                           vars[hash[0]]+=","+hash[1];
                       }
                       else
                       {
                           vars.push(hash[0]);
                           vars[hash[0]] = hash[1];
                       }
                   }

                   return vars;
               }
             
        });
        
       
      </script>
     
      
   </body>
</html>