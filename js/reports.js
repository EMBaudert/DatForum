
$(document).ready(function() {

	$('.solved').button().click(function(){
		var query = "UPDATE FROM reports WHERE PKID_report = " + $(this).attr("id");
				
		var sql = {
			sql: query
		}
		
      var answer = $.post("func/insertSQL.php",sql);
      
      answer.done(function() {
      	location.reload();
      });
	});    
});