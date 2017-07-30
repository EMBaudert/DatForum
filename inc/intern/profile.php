<?PHP

#Für das Profil gibt es zwei unterschiedliche Ansichten. Die des eigenen Benutzers, der seine Daten ändern kann und die des
#externen Benutzers, oder des Besuchers, der dann nur die Daten ansehen kann.

if(!isset($_GET["uid"])||!checkID($_GET["uid"])){        #Wenn die eingegebene UserID nicht existiert
   echo '<div id="setTitle" class="hide">Profile</div><h1>Keine bekannte User-ID!</h1>';
}else{
            
	$sql = "SELECT * FROM user WHERE PKID_user=?";
	
	$data=SQLQuery1($sql,$_GET["uid"]);                   #Userinformationen des gewünschten Profils abrufen
   
   echo '<div id="setTitle" style="display:none;">'.$data["username"].'\'s Profile</div> 
   <h1>'.$data["username"].'\'s Profile</h1> '; 
   if(isset($_SESSION["logged"])&&$_SESSION["logged"]&&$_SESSION["PKID"]==$_GET["uid"]){     #Profilansicht des eigenen Profils

      $_SESSION["username"]=$data["username"];
      $_SESSION["firstname"]=$data["firstname"];	
   	$_SESSION["secondname"]=$data["secondname"];	
   	$_SESSION["email"]=$data["email"];	
      $_SESSION["PKID"]=$data["PKID_user"];
   	$PASS=$data["password"];
      



      if (isset($_POST["submit"])){                                     #Wenn auf Änderungen Speichern geklickt wurde, ist in dieser Variable etwas enthalten
         if(checkname()){                                               #Bei Namensänderunge werden diese wieder überprüft
            $_SESSION["firstname"]=$_POST["firstname"];
            $_SESSION["secondname"]=$_POST["secondname"];
         }
         if(checkemail()){                                              #Genau so für E-Mail
            $_SESSION["email"]=$_POST["email"];
         }
         if($_POST["oldpassword"]!=""&&checklogin($_SESSION["username"],hash('sha512',$_POST["oldpassword"]))&&checkpass()){  #Oder für das Passwort
            $PASS=hash('sha512',$_POST["password"]);
         }
         $imageFileType = pathinfo(basename($_FILES['datei']['name']),PATHINFO_EXTENSION);         #Oder ein neues Profilbild
         $filename=$data["pb_path"];
         if(strlen($imageFileType)>1){                                                             #Überprüfung des richtigen Formats für ein neues Profilbild
            if($imageFileType!="gif"){
               $imageFileType="png";
            }
            $picdata = getimagesize($_FILES['datei']['tmp_name']);                                 #Für eine gute Anzeige darf das Bild nicht höher als breit sein
            if($picdata[1]>$picdata[0]){
               echo '<script>alert("Das Profilbild darf nicht hoeher als breit sein!");</script>';
            }else{
               $filename="pic/pb_".$_SESSION["PKID"].".".$imageFileType;                           #Wenn alles passt, wird der neue Bildname zusammengestellt
               move_uploaded_file($_FILES['datei']['tmp_name'], $filename);                        #Und das Bild gespeichert
            }
         }
         #Alle Änderungen werden gespeichert
      	$sql = "UPDATE user SET firstname='".$_SESSION["firstname"]."', secondname='".$_SESSION["secondname"]."', email='".$_SESSION["email"]."', password='".$PASS."', pb_path='".$filename."', signature='".makeSecure($_POST["signature"])."' WHERE PKID_user=".$_SESSION["PKID"];
      	$statement = $pdo->prepare($sql);
      	$statement->execute();   
         header("Cache-Control: no-cache, must-revalidate");
      }
         
   	$sql = "SELECT * FROM user WHERE PKID_user=?";
   	$data=SQLQuery1($sql,$_SESSION["PKID"]);                               #Nutzerinformationen des aktuellen Benutzers aus der DB holen
   
      #Hier wird nun das Formular bereit um Änderungen abzuschicken vorausgefüllt 
         ?>

              
                  <form action="intern.php?p=profile&uid=<?PHP echo $_SESSION["PKID"]; ?>" method="POST" enctype="multipart/form-data"><br />
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"> 
            <div align="left" style="margin:10px;">
               <img title="Profilbild" src="<?PHP echo $data["pb_path"]; ?>" class="img-rounded" width="200px" />
            </div>
            <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Profile Picture</span>
           
                  <label class="btn btn-default" style="border-radius: 0px 5px 5px 0px;width:160px;">
                     Choose new file <input id="fileToUpload" class="hide form-control" type="file" name="datei" />
                  </label><span id="filechosen"></span>
             </div>
         <div class="form-group">
           <label for="comment">Signature:</label>
           <textarea class="form-control" rows=5 cols=40 style="resize:none;max-width:350px;" name="signature" id="comment"><?PHP if(isset($data["signature"])){echo specialCombosBack($data["signature"]); }?></textarea>
           <small>**<b>Fett</b>**   --<u>Unterstrichen</u>--   __<i>Italic</i>__   ~~<s>Durchgestrichen</s>~~   ++Zeilenumbruch</small>
         </div>

         </div>

                     <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Username</span>
              <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="username" 
              <?PHP if(isset($data["username"])){?>value="<?PHP echo $data["username"]."\""; }?> readonly>
            </div>
            <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">First Name</span>
              <input type="text" class="form-control" placeholder="First Name" aria-describedby="basic-addon1" name="firstname" 
              <?PHP if(isset($data["firstname"])){?>value="<?PHP echo $data["firstname"]."\""; }?>>
            </div>
            <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Second Name</span>
              <input type="text" class="form-control" placeholder="Second Name" aria-describedby="basic-addon1" name="secondname" 
              <?PHP if(isset($data["secondname"])){?>value="<?PHP echo $data["secondname"]."\""; }?>>
            </div>
            <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">E-Mail</span>
              <input type="email" class="form-control" placeholder="E-Mail Adress" aria-describedby="basic-addon1" name="email" 
              <?PHP if(isset($data["email"])){?>value="<?PHP echo $data["email"]."\""; }?>>
            </div>
            <div class="dropup">
           <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="collapse" data-target="#changepasswordthing" aria-haspopup="true" aria-expanded="false" style="margin:10px; width:320px;">
             Change Password
           </button>
           <div class="collapse" id="changepasswordthing">
             <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
              <input type="password" class="form-control" placeholder="Old Password" aria-describedby="basic-addon1" name="oldpassword">
            </div>
             <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
              <input type="password" class="form-control" placeholder="New Password" aria-describedby="basic-addon1" name="password">
            </div>
              <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
              <input type="password" class="form-control" placeholder="Repeat New Password" aria-describedby="basic-addon1" name="password2">
            </div>
           </div>
         </div>
            
            
           
            <div align="left">
               <button style="margin:10px;align:right;" class="btn btn-default" name="submit" type="submit" >
                <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Save changes
               </button>
            </div>
            </div>
         </div>

                  
                  </form>
         <!-- Wenn ein neues Profilbild ausgewählt wurde, wird ein Häkchen neben dem Upload-Button angezeigt -->
                  <script>
                     $('#fileToUpload').click(function() {
                        $('#fileToUpload').change(function() {
                                 $('#filechosen').html("  <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>");
                             }); 
                        });
                  </script>
         <?PHP  
         }else{
         #Ab hier folgt die Ansicht, wenn man ein fremdes Profil ansieht
         ?>
         <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div align="left">
               <img title="Profilbild" src="<?PHP echo $data["pb_path"]; ?>" class="img-rounded" width="200px" />
            </div>
            <?PHP if(isset($data["signature"])){echo '
         <div class="form-group">
           <label for="comment">Signature:</label>
            <p id="comment">'.$data["signature"].'</p>
         </div>';} ?>

         </div>
                              <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

            <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Username</span>
              <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="username" 
              <?PHP if(isset($data["username"])){?>value="<?PHP echo $data["username"]."\""; }?> readonly>
            </div>
            <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">First Name</span>
              <input type="text" class="form-control" placeholder="First Name" aria-describedby="basic-addon1" name="firstname" 
              <?PHP if(isset($data["firstname"])){?>value="<?PHP echo $data["firstname"]."\""; }?> readonly>
            </div>
            <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Second Name</span>
              <input type="text" class="form-control" placeholder="Second Name" aria-describedby="basic-addon1" name="secondname" 
              <?PHP if(isset($data["secondname"])){?>value="<?PHP echo $data["secondname"]."\""; }?> readonly>
            </div>
            <div class="input-group" style="margin:10px;">
              <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">E-Mail</span>
              <input type="email" class="form-control" placeholder="E-Mail Address" aria-describedby="basic-addon1" name="email" 
              <?PHP if(isset($data["email"])){?>value="<?PHP echo $data["email"]."\""; }?> readonly>
            </div>
           <?PHP
           if(isset($_SESSION["logged"])&&$_SESSION["logged"]==true)  {
            ?>
      <!-- Wenn man angemeldet ist, kann man über das Profil direkt zu den Nachricht wechseln, um diesen Benutzer eine Nachricht zu senden -->
            <a href="intern.php?p=message&cp=<?PHP echo $_GET["uid"]; ?>"><button class="btn btn-default" type="button" id="dropdownMenu1" style="margin:10px; width:320px;">
             <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Write Message
           </button></a>
           <?PHP
           } 
           ?>
            </div>
           
         </div>
         <?PHP
      }
      
}
?>