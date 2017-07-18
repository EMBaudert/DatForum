
$(document).ready(function() {

	$('.solved').button().click(function(){
		var query = "DELETE FROM reports WHERE PKID_report = " + $(this).attr("id");
		
		alert(query);
		
		var sql = {
			sql: query
		}
		
      var answer = $.post("func/insertSQL.php",sql);
      
      answer.done(function() {
      	location.refresh;
      });
	});    
});