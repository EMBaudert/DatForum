<!DOCTYPE html>
<html lang="en">
   <head>
     <meta charset="UTF-8">
     <title>Summernote</title>
     
     <!-- Das neueste kompilierte und minimierte CSS -->
      <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

      <!-- Optionales Theme -->
      <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">

      <!-- Latest compiled and minified JavaScript -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
     
     <!-- include summernote css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
     
     
   </head>

   <body>
      <div class="container">
      
         <?php
            require_once('inc/navbar.php');
         ?>
         <div class="row">
            <h2>Thread erstellen</h2>
         </div>
         <div class="row">
            <div class="input-group">
               <span class="input-group-addon">Threadtitel</span>
               <input type="text" class="form-control" id="threadtitle" placeholder="" aria-describedby="threadtitle">
            </div>
         </div>
         <div class="row">
            <div id="summernote">
               <p>...</p>
            </div>
            
            <div class="btn-group pull-right" role="group">
                <a class ="btn btn-default" id="target"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>
            </div>
         </div>
         
         <?php
            include_once('inc/footer.html');
         ?>
      </div>
     
      <script>
        $(document).ready(function() {
            $('#summernote').summernote();
            
            $('#target').button().click(function(){
                var markupStr = $('#summernote').summernote('code');
                var d = new Date();
                if(getUrlVars()["from"] == "menu"){
                
                     var query = {sql: "INSERT INTO `thread` (`PKID_thread`, `FK_menu`, `theme`, `FK_Creator`) VALUES (NULL, '"
                                       +getUrlVars()["id"]+"', '"+ $('#threadtitle').val() +"', '"+getUrlVars()["creator"]+"');", 
                                  type: "newThread",
                                  theme: $('#threadtitle').val(),
                                  creator: getUrlVars()["creator"]
                                 };
                     var query21 = "INSERT INTO `post` (`PKID_post`, `FK_user`, `FK_thread`, `date`, `time`, `text`) VALUES (NULL, '"+getUrlVars()["creator"]+"', '";
                     var query22 = "', '"+d.getFullYear()+"-"+d.getMonth()+"-"+d.getDate()+"', '"+d.getHours()+"-"+d.getMinutes()+"-"+d.getSeconds()+"', '"+markupStr+"');";
                     sendSQL(query, query21, query22);
                     
                     //update number of posts
                     var query = "UPDATE user SET numberposts = numberposts+1 WHERE PKID_user = "+getUrlVars()["creator"];
                     var sql = {
                        sql: query
                     }
                     $.post("func/insertSQL.php", sql);
                     

                } 
                
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
             
             
               function sendSQL(sql1, sql21, sql22) {
                  $.post("func/insertSQL.php",sql1, function(result){
                     var query = sql21 + String(result) + sql22;
                     var newStr= {sql: query};
                     $.post("func/insertSQL.php", newStr);
                     $("#summernote").animate({"left":"+=100px"},function() {location.href = "thread.php?thread="+result+"&page=1"});
                  
                  });
                  
               }
             
             
        });
        
       
      </script>
     
      
   </body>
</html>