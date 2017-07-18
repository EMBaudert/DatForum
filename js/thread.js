
/* Damit die Signatur bei jedem Post am unteren Ende des divs ist, auch wenn der content wenig inhalt hat 
         for(var i = 0; i<$('.contentdiv').length; i++){
            var height = $('#image'+i).height();
            $('#div'+i).css("min-height", height+"px");
         }*/
      
         $(document).ready(function() {
         
         //Meldung an SQL wenn 
            $('.report').button().click(function(){
            
            alert(getUrlVars()['thread']);
            
               var reason = prompt("Bitte Grund angeben: ", "");
               
               var query1="INSERT INTO `reports` (`PKID_report`, `FK_user`, `FK_thread`, `FK_post`, `reason`, `done`, `doneby`) VALUES (NULL, "+$(this).attr("creator")+", '"+getUrlVars()['thread']+"', '"+$(this).attr("id")+"', '"+reason+"', '0', NULL)";
               alert(query1);
               var sql = {
               	sql: query1
               }
               
              /* var queryPart1 = "INSERT INTO `reports` (`PKID_report`, `FK_user`, `reason`) VALUES (NULL, '";
               var queryPart2 = "', '"+reason+"')";
               
               var sql = {
                  type: 'report',
                  query1: queryPart1,
                  query2: queryPart2
               } */
               
               var answer = $.post("func/insertSQL.php",sql);
               
               answer.done(function(){
               
               alert("Gemeldet!");
               });
            });
            
            $(".delete").click(function(){
               	
                  var query = "DELETE FROM `post` WHERE `post`.`PKID_post` = "+$(this).attr("id");
                  alert(query);
                  var sql = {
                     sql: query
                  }
                  $.post("func/insertSQL.php",sql, function(result){
                     alert(result);
                  });
            });
            
            
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

