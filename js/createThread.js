

	$(document).ready(function() {
			
			
/* Setzt den richtig Radiobbutton auf selected */
				$('input[type=radio][name=thread][value=thread]').prop('checked',true);
	         
/* Abschicken button gedrückt */
            $('#target').button().click(function(){
            
	            var text = CKEDITOR.instances.editor1.getData();
               text = replaceUmlaut(text);
               //überprüft auf leere Eingaben
               if(!/^\s/g.test(text)){
						var d = new Date(Date.now());
						createThread(text, d);
                }else{
	                alert("Ung\u00fcltige Eingabe!");
                }
             });
             
             $('#addMenupoint').button().click(function(){
					var text = $('#threadtitle').val();
               text = replaceUmlaut(text);
               //überprüft auf leere eingaben
               if(!/^\s/g.test(text)){
						var d = new Date(Date.now());
						createMenuPoint(text, d);
                }else{
	                alert("Ung\u00fcltige Eingabe!");
                }
             
             
             });
             
/* Erstellt in der Datenbank einen Thread */
             function createThread(text, d){
             	var query = {sql: "INSERT INTO `thread` (`PKID_thread`, `FK_menu`, `theme`, `FK_Creator`) VALUES (NULL, '"
               	+getUrlVars()["id"]+"', '"+ $('#threadtitle').val() +"', '"+userID+"');", 
                  type: "newThread",
                  theme: $('#threadtitle').val(),
                  creator: userID
               };
               
               //In der Php wird das SQL-Statement mit den letzten daten Fertiggestellt.
               var query21 = "INSERT INTO `post` (`PKID_post`, `FK_user`, `FK_thread`, `date`, `time`, `text`) VALUES (NULL, '"+userID+"', '";
               var query22 = "', '"+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+"', '"+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds()+"', '"+text+"');";
/* sendSQL adds post with correct ID */               
               sendSQL(query, query21, query22);
             }
             
/* Erstellt in der Datenbank einen Menüpunkt */
             function createMenuPoint(texxt, d){
             
             /*abhängig vom Radiobutton wird der passende Parameter übergeben
             	In der Datenbank ist festgelegt ob der menüpunkt weitere Menüpunkte beihnaltet oder Threads
             */
                  if($('input[name=thread]:checked').val() == 'menupoint'){
                  	if(getUrlVars()["id"]==0){
                  		query = "INSERT INTO `menu` (`PKID_menu`, `FK_menu`, `title`, `threads`) VALUES (NULL, NULL, '"+ $('#threadtitle').val() +"', '0')";	
                  	}else {
                  		query = "INSERT INTO `menu` (`PKID_menu`, `FK_menu`, `title`, `threads`) VALUES (NULL, "+getUrlVars()["id"]+", '"+ $('#threadtitle').val() +"', '0')";	
                  	}
                  }else {
                  	if(getUrlVars()["id"]==0){
	                     query = "INSERT INTO `menu` (`PKID_menu`, `FK_menu`, `title`, `threads`) VALUES (NULL, NULL, '"+ $('#threadtitle').val() +"', '1')";
	                  }else {
	                  	query = "INSERT INTO `menu` (`PKID_menu`, `FK_menu`, `title`, `threads`) VALUES (NULL, "+getUrlVars()["id"]+", '"+ $('#threadtitle').val() +"', '1')";	
	                  }
                  }
                  
                  var sql = {
                     sql: query
                  }
                  var answer = $.post("func/insertSQL.php", sql);
                  answer.done(function(){
                     var url = "forum.php?p=menu&menu="+getUrlVars()["id"]+"&page=last";
                     $(location).attr('href',url);
                  });
             }
             
             //liest parameter aus URL aus
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
                     var answer = $.post("func/insertSQL.php", newStr);
                     
                     //wenn fertig ausgeführt, erhöhe zäler
                     answer.done( function(){
                     	//update number of posts
               			var query = "UPDATE user SET numberposts = numberposts+1 WHERE PKID_user = "+userID;
			               var sql = {
			               	sql: query
			               }
			               //wenn fertig ausgeführt geehe zu erstlltem post
			               var answer = $.post("func/insertSQL.php", sql);
			                  answer.done(function(){
			                     var url = "forum.php?p=thread&thread="+String(result)+"&page=1";
			                     $(location).attr('href',url);
			               });
                     });
                  
                  });
                  
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
        