<?PHP
   if(!isset($_GET["uid"])||!checkID($_GET["uid"])){
      echo "<h1>Keine bekannte User-ID!</h1>";
   }else{
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
            
      	$sql = "SELECT * FROM user WHERE PKID_user='".$_GET["uid"]."'";
      	
      	$user = $pdo->query($sql);
      	$user->execute();
      	$data=$user->fetch();
         
         
      if(isset($_SESSION["logged"])&&$_SESSION["logged"]&&$_SESSION["PKID"]==$_GET["uid"]){
      
         $_SESSION["username"]=$data["username"];
         $_SESSION["firstname"]=$data["firstname"];	
      	$_SESSION["secondname"]=$data["secondname"];	
      	$_SESSION["email"]=$data["email"];	
         $_SESSION["PKID"]=$data["PKID_user"];
      	$PASS=$data["password"];
         



         if (isset($_POST["submit"])){
            if(checkname()){
               $_SESSION["firstname"]=$_POST["firstname"];
               $_SESSION["secondname"]=$_POST["secondname"];
            }
            if(checkemail()){
               $_SESSION["email"]=$_POST["email"];
            }
            if($_POST["oldpassword"]!=""&&checklogin($_SESSION["username"],hash('sha512',$_POST["oldpassword"]))&&checkpass()){
               $PASS=hash('sha512',$_POST["password"]);
            }
            $imageFileType = pathinfo(basename($_FILES['datei']['name']),PATHINFO_EXTENSION);
            $filename=$data["pb_path"];
            if(strlen($imageFileType)>1){
               $filename="pic/pb_".$_SESSION["PKID"].".".$imageFileType;
               move_uploaded_file($_FILES['datei']['tmp_name'], $filename);
            }
            #echo "<script>alert('Der Upload war erfolgreich!')</script>";
         	$sql = "UPDATE user SET firstname='".$_SESSION["firstname"]."', secondname='".$_SESSION["secondname"]."', email='".$_SESSION["email"]."', password='".$PASS."', pb_path='".$filename."', signature='".$_POST["signature"]."' WHERE PKID_user=".$_SESSION["PKID"];
         	$statement = $pdo->prepare($sql);
         	$statement->execute();   
            header("Cache-Control: no-cache, must-revalidate");
         }
            
      	$sql = "SELECT * FROM user WHERE PKID_user='".$_SESSION["PKID"]."'";
      	
      	$user = $pdo->query($sql);
      	$user->execute();
      	$data=$user->fetch();
         
?>

         <h1>Profil bearbeiten</h1>
         <form action="intern.php?p=profile&uid=<?PHP echo $_SESSION["PKID"]; ?>" method="POST" enctype="multipart/form-data"><br />

            <div id="profile">
               <table width="100%">
                  <tr>
                     <td rowspan=6><img title="Profilbild" src="<?PHP echo $data["pb_path"]; ?>" width="200px" /></td>
                     <td>Benutzername:</td><td><?PHP if(isset($_SESSION["username"])){echo $_SESSION["username"]; }?></td>
                  </tr>
                  <tr>
                     <td>Vorname:</td><td><input type="text" name="firstname" value="<?PHP if(isset($_SESSION["firstname"])){echo $_SESSION["firstname"]; }?>"></td>
                  </tr>
                  <tr>
                     <td>Nachname:</td><td><input type="text" name="secondname" value="<?PHP if(isset($_SESSION["secondname"])){echo $_SESSION["secondname"]; }?>"></td>
                  </tr>
                  <tr>
                     <td>E-Mail Adresse:</td><td><input type="text" name="email" value="<?PHP if(isset($_SESSION["email"])){echo $_SESSION["email"]; }?>"></td>
                  </tr>
                  <tr>
                     <td>Altes Passwort:</td><td><input type="password" name="oldpassword"></td>
                  </tr>
                  <tr>
                     <td>Neues Passwort:</td><td><input type="password" name="password"></td>
                  </tr>
                  <tr>
                     <td>Signatur:</td>
                     <td>Neues Passwort wiederholen:</td><td><input type="password" name="password2"></td>
                  </tr>
                  <tr>
                     <td rowspan=2><textarea name="signature" rows=5 cols=40 style="resize:none"><?PHP if(isset($data["signature"])){echo $data["signature"]; }?></textarea></td>
                     <td>Neues Profilbild:</td><td><input type="file" name="datei" /></td>
                  </tr>
                  <tr>
                     <td></td><td><br><input name="submit" type="submit" value=" &Auml;nderungen speichern"></td>
                  </tr>
               </table>
            </div>
         </form>
<?PHP  
      }else{
?>
         <h1>Profil von <?PHP if(isset($data["username"])){echo $data["username"]; }?></h1>

         <div id="profile">
            <table width="100%">
               <tr>
                  <td rowspan=4 colspan=2><img title="Profilbild" src="<?PHP echo $data["pb_path"]; ?>" width="200px" /></td>
                  <td>Benutzername:</td><td><?PHP if(isset($data["username"])){echo $data["username"]; }?></td>
               </tr>
               <tr>
                  <td>Vorname:</td><td><?PHP if(isset($data["firstname"])){echo $data["firstname"]; }?></td>
               </tr>
               <tr>
                  <td>Nachname:</td><td><?PHP if(isset($data["secondname"])){echo $data["secondname"]; }?></td>
               </tr>
               <tr>
                  <td>E-Mail Adresse:</td><td><?PHP if(isset($data["email"])){echo $data["email"]; }?></td>
               </tr>
               <tr>
                  <td colspan=2 title="Signatur"><?PHP if(isset($data["signature"])){echo $data["signature"]; }?></td>
               </tr>
         </table>
         </div>
<?PHP
      }
      
}
?>