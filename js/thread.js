
/* Damit die Signatur bei jedem Post am unteren Ende des divs ist, auch wenn der content wenig inhalt hat 
         for(var i = 0; i<$('.contentdiv').length; i++){
            var height = $('#image'+i).height();
            $('#div'+i).css("min-height", height+"px");
         }*/
      
         $(document).ready(function() {
         
         	/* setzt die Höhe im Contentblock passend zum Profilbild */
	         $.each($(".profile-picture"), function() {
		         var id= $(this).attr('id');
					var height = $(this).height();
					var divid = "#div"+id;
				   $(divid).css('min-height', height);
				});
          
            $('#report').button().click(function(){
               var reason = prompt("Bitte Grund angeben: ", "");
               
               var queryPart1 = "INSERT INTO `reports` (`PKID_report`, `FK_user`, `reason`) VALUES (NULL, '";
               var queryPart2 = "', '"+reason+"')";
               
               var sql = {
                  type: 'report',
                  query1: queryPart1,
                  query2: queryPart2
               }
               
               $.post("func/insertSQL.php",sql);
               
            });
            
            $(".delete").click(
               function()
               {
                  var query = "DELETE FROM `post` WHERE `post`.`PKID_post` = "+$(this).attr("id");
                  alert(query);
                  var sql = {
                     sql: query
                  }
                  $.post("func/insertSQL.php",sql, function(result){
                     alert(result);
                  });;
            });
            
            
         });

