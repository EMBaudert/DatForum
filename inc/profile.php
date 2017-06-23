<?PHP
   if(!isset($_GET["uid"])||!checkID($_GET["uid"])){
      echo "<h1>Keine bekannte User-ID!</h1>";
   }else{
         $pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');
            
      	$sql = "SELECT * FROM user WHERE PKID_user='".$_GET["uid"]."'";
      	
      	$user = $pdo->query($sql);
      	$user->execute();
      	$data=$user->fetch();
         
        echo " <h1>".$data["username"]."'s Profile</h1> "; 
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

     
         <form action="intern.php?p=profile&uid=<?PHP echo $_SESSION["PKID"]; ?>" method="POST" enctype="multipart/form-data"><br />
            <div style="width:300px;">
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
     <input type="email" class="form-control" placeholder="E-Mail Address" aria-describedby="basic-addon1" name="email" 
     <?PHP if(isset($data["email"])){?>value="<?PHP echo $data["email"]."\""; }?>>
   </div>
   <div class="dropup">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin:10px; width:280px;">
    Change Password
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li>
    <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
     <input type="password" class="form-control" placeholder="Old Password" aria-describedby="basic-addon1" name="oldpassword">
   </div>
    </li>
    <li>
    <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
     <input type="password" class="form-control" placeholder="New Password" aria-describedby="basic-addon1" name="password">
   </div>
   </li>
    <li>
     <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
     <input type="password" class="form-control" placeholder="Repeat New Password" aria-describedby="basic-addon1" name="password2">
   </div>
   </li>
  </ul>
</div>
   
   
  
   <div align="right">
      <button style="margin:10px;align:right;" class="btn btn-default" name="submit" type="submit" >
       <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Save changes
      </button>
   </div>
   <div align="center">
      <img title="Profilbild" src="<?PHP echo $data["pb_path"]; ?>" class="img-rounded" width="200px" />
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Profile Picture</span>
  
         <label class="btn btn-default" style="width:160px;">
            Choose new file <input class="form-control" type="file" name="datei" style="display:none;" />
         </label>
    </div>
<div class="form-group">
  <label for="comment">Signature:</label>
  <textarea class="form-control" rows=5 cols=40 style="resize:none" name="signature" id="comment"><?PHP if(isset($data["signature"])){echo $data["signature"]; }?></textarea>
</div>

</div>


         
         </form>
<?PHP  
      }else{
?>

                     <div style="width:300px;">
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
   
   <div align="center">
      <img title="Profilbild" src="<?PHP echo $data["pb_path"]; ?>" class="img-rounded" width="200px" />
   </div>
<div class="form-group">
  <label for="comment">Signature:</label>
   <p><?PHP if(isset($data["signature"])){echo $data["signature"]; }?></p>
</div>

</div>
<?PHP
      }
      
}
?>