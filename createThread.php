<!DOCTYPE html>
<html lang="en">
   <head>
     <meta charset="UTF-8">
     <title>Create Thread</title>
     
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
         ?>
         <div class="row">
            <h2>Thread erstellen</h2>
         </div>
         <div class="row">
            <div class="input-group margin-bottom">
               <span class="input-group-addon">Threadtitel</span>
               <input type="text" class="form-control" id="threadtitle" placeholder="" aria-describedby="threadtitle">
            </div>
         </div>
         <?php if($_GET['type']== 'thread'){ ?>
            <div class="row">
               <trix-editor id="trix"></trix-editor>
            </div>
         <?php } else if($_GET['type']=='menupoint'){ ?>
            <div class="row">
            
            </div>
         <?php } ?>
         <div class="row">
            <a class ="btn btn-default btn-textfield pull-right" id="target"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>
         </div>
         
         <?php
            include_once('inc/footer.html');
         ?>
      </div>
     
      <script>
        $(document).ready(function() {
            
            $('#target').button().click(function(){
            
               var text = $('#trix').val();
                var d = new Date();
                if(getUrlVars()["type"] == "thread"){
                
                     var query = {sql: "INSERT INTO `thread` (`PKID_thread`, `FK_menu`, `theme`, `FK_Creator`) VALUES (NULL, '"
                                       +getUrlVars()["id"]+"', '"+ $('#threadtitle').val() +"', '"+getUrlVars()["creator"]+"');", 
                                  type: "newThread",
                                  theme: $('#threadtitle').val(),
                                  creator: getUrlVars()["creator"]
                                 };
                     var query21 = "INSERT INTO `post` (`PKID_post`, `FK_user`, `FK_thread`, `date`, `time`, `text`) VALUES (NULL, '"+getUrlVars()["creator"]+"', '";
                     var query22 = "', '"+d.getFullYear()+"-"+d.getMonth()+"-"+d.getDate()+"', '"+d.getHours()+"-"+d.getMinutes()+"-"+d.getSeconds()+"', '"+text+"');";
                     sendSQL(query, query21, query22);
                     
                     //update number of posts
                     var query = "UPDATE user SET numberposts = numberposts+1 WHERE PKID_user = "+getUrlVars()["creator"];
                     var sql = {
                        sql: query
                     }
                     $.post("func/insertSQL.php", sql);
                     

                } else if(getUrlVars()["type"]=="menupoint"){
                  var threads;
                  var sql={
                     type: "getThreads",
                     fk: getUrlVars()["id"]
                  }
                  $.post("func/insertSQL.php", sql, function(result){
                     threads = result;
                  });  
                    var query;               
                  if(getUrlVars()["id"] == 0){
                     query = "INSERT INTO `menu` (`PKID_menu`, `FK_menu`, `title`, `threads`) VALUES (NULL, NULL, '"+ $('#threadtitle').val() +"', '0')";
                  }else {
                     query = "INSERT INTO `menu` (`PKID_menu`, `FK_menu`, `title`, `threads`) VALUES (NULL, "+getUrlVars()["id"]+", '"+ $('#threadtitle').val() +"', '"+threads+"')";
                  }
                  
                  alert(query);
                  
                  var sql = {
                     sql: query
                  }
                  var answer = $.post("func/insertSQL.php", sql);
                  answer.done(function(){
                     var url = "menu.php?menu="+getUrlVars()["id"]+"&page=last";
                     $(location).attr('href',url);
                  });
                  
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
                     
                     //location.href = "thread.php?thread="+result+"&page=1";
                  
                  });
                  
               }
             
             
        });
        
       
      </script>
     
      
   </body>
</html>