<?PHP
require_once 'func/user.func.php';
$securequestion = selectsecquest();
$securenumber = substr($securequestion,0,1);
$securequestion = substr($securequestion,1);
?>
<form action="intern.php?p=register" method="POST">
<div style="width:300px;">
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Username</span>
     <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="username" 
     <?PHP if(isset($_SESSION["username"])){ echo 'value="'.$_SESSION["username"].'"'; }?>>
   </div> 
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">First Name(s)</span>
     <input type="text" class="form-control" placeholder="First Name(s)" aria-describedby="basic-addon1" name="firstname" 
     <?PHP if(isset($_POST["firstname"])){ echo 'value="'.$_POST["firstname"].'"'; }?>>
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Second Name</span>
     <input type="text" class="form-control" placeholder="Second Name" aria-describedby="basic-addon1" name="secondname" 
     <?PHP if(isset($_POST["secondname"])){ echo 'value="'.$_POST["secondname"].'"'; }?>>
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">E-Mail</span>
     <input type="text" class="form-control" placeholder="E-Mail Address" aria-describedby="basic-addon1" name="email" 
     <?PHP if(isset($_POST["email"])){ echo 'value="'.$_POST["email"].'"'; }?>>
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
     <input type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" name="password">
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
     <input type="password" class="form-control" placeholder="Repeat Password" aria-describedby="basic-addon1" name="password2">
   </div>
    <div class="input-group" style=" width:280px;margin:10px;">
      <span class="input-group-addon">
        <input type="checkbox" name="readit" aria-label="...">
      </span>
      <p>Ich habe die <a href="documents/Hinweise_zu_Richtlinien_und_Datenschutzbestimmungen.pdf" target="_blank" style="color:0x337bb7;">
                     Hinweise zu Richtlinien und Datenschutzbestimmungen </a> gelesen und akzeptiere Diese.</p>
    </div>
   <div class="input-group" style=" width:280px;margin:10px;">
     <h4><span class="label label-default">Sicherheitsfrage</span></h4>
   </div>
   <p></p>
   <div class="input-group" style=" width:280px;margin:10px;">
     <input type="hidden" name="questnumb" value="<?PHP echo $securenumber; ?>" />
     <input type="text" class="form-control" placeholder="<?PHP echo $securequestion; ?>" aria-describedby="basic-addon1" name="secQuest" style="border-radius: 5px 5px 5px 5px;">
   </div>
   <div align="right">
      <button style="margin:10px;align:right;" class="btn btn-default" name="submit" type="submit" >
       <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Sign Up
      </button>
   </div> 
</div>
</form>