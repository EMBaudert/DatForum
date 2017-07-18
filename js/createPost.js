         document.addEventListener("trix-initialize", function(event) {
            var element = document.querySelector("trix-editor");
            element.editor.insertString(text);
          });
      
      
        $(document).ready(function() {
            var d = new Date();
            
            
            //Button für neuen Post
            $('#new').button().click(function(){
                  
                  
                  
                  var text = $('#trix').val();
                  
                  if(/^\s+$/.test(word)){
            			alert("drin");
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
	                  
	                  
	                  $("#trix").animate({"left":"+=100px"},function() {location.href = "forum.php?p=thread&thread="+getUrlVars()["id"]});
                  }else{
                  	alert("Ungueltige Eingabe!");
                  }
             });   
             
             //Button für editieren 
             $('#edit').button().click(function(){
                 // Text wird gespeichert
                 	var text = $('#trix').val();
                  if(/^\s+$/.test(word)){                 
							
							var query = "UPDATE post SET text = '"+text+"' WHERE PKID_post = "+getUrlVars()["id"];
                 		//Post wird erstellt
                 		var sql = {sql: query};
	                  //post wird aufgerufen
                 		$.post("func/insertSQL.php",sql);
                 		$("#trix").animate({"left":"+=100px"},function() {location.href = "forum.php?p=thread&thread="+getUrlVars()["id"]});
                 	}else{
                 		alert("Ung&uuml;ltige Eingabe!");
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
             
        });
        