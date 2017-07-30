
$(document).ready(function() {


	$('.solved').button().click(function(){
	/* setzt done auf 1 (--> erledigt) und fügt den Benutzer der das bearbeitet hat hinzu*/
		var query = "UPDATE `reports` SET `done` = '1', `doneby` = '"+userID+"' WHERE `reports`.`PKID_report` = "+$(this).attr("id"); 
				
		var sql = {
			sql: query
		}
		
      var answer = $.post("func/insertSQL.php",sql);
      
      answer.done(function() {
      	location.reload();
      });
	});    
});