         
      
        $(document).ready(function() {
            var d = new Date();
            
            CKEDITOR.instances.editor1.setData(text);
            
            //Button für neuen Post
            $('#new').button().click(function(){
                  
                  var text = CKEDITOR.instances.editor1.getData();
                  text = replaceUmlaut(text);
                  if(!/<p>(&nbsp;)*<\/p>/g.test(text)){
                  
                  var time = "'"+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds()+"'";
                  
                  alert(time);
                  
	                  //Einfügen in post wird erstellt
	                  var query =  "INSERT INTO `post` (`PKID_post`, `FK_user`, `FK_thread`, `date`, `time`, `text`) VALUES (NULL, '"+user+"', '"
	                  +getUrlVars()["threadid"]+"', '"+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+"', "+time+", '"+text+"');";
	                  
	                  alert(query);
	                  
	                  //Post wird erstellt
	                  var sql = {sql: query};
	                  
	                  //post wird aufgerufen
	                  $.post("func/insertSQL.php",sql);
	                  
	                  //update number of posts
	                  var query = "UPDATE user SET numberposts = numberposts+1 WHERE PKID_user = "+getUrlVars()["creator"];
	                  var sql2= {
	                     sql:  query
	                  };
	                  var answer = $.post("func/insertSQL.php",sql2);

	              		answer.done(function(){
			                  location.href = "forum.php?p=thread&thread="+getUrlVars()["threadid"];	                     
		               });
                  }else{
                  	alert("Ung\u00fcltige Eingabe!");
                  }
             });   
  		
             //Button für editieren 
             $('#edit').button().click(function(){
                 // Text wird gespeichert
                 	
                 	var text = CKEDITOR.instances.editor1.getData();
                  text = replaceUmlaut(text);
                  if(!/<p>(&nbsp;)*<\/p>/g.test(text)){   
							
							var query = "UPDATE post SET text = '"+text+"' WHERE PKID_post = "+getUrlVars()["id"];
                 		//Post wird erstellt
                 		var sql = {sql: query};
	                  //post wird aufgerufen
	                  var answer = $.post("func/insertSQL.php",sql);
                 		
                 		answer.done(function(){
		                  location.href = "forum.php?p=thread&thread="+getUrlVars()["threadid"]+"&post="+getUrlVars()["id"];	                     
	                  });
                 		

                 		
                 	}else{
                 		alert("Ung\u00fcltige Eingabe!");
                 	}
             }); 
             
             function getUrlVars(){
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
             
             function replaceUmlaut(str){
             	str.replace(/\u00e4/, "&auml;");
					str.replace(/\u00c4/, "&Auml;");
             	str.replace(/\u00d6/, "&Ouml;");
             	str.replace(/\u00f6/, "&ouml;");
             	str.replace(/\u00dc/, "&Uuml;");
             	str.replace(/\u00fc/, "&uuml;");
             	str.replace(/\u00fc/, "&szlig;");
             	
             	return str;
             }
             
        });
        