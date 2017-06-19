<form action="intern.php?p=register" method="POST">
<div style="min-width:300px;">
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Username</span>
     <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="username" 
     <?PHP if(isset($_POST["username"])){?>value="<?PHP echo $_POST["username"]."\""; }?>>
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">First Name</span>
     <input type="text" class="form-control" placeholder="First Name" aria-describedby="basic-addon1" name="firstname" 
     <?PHP if(isset($_POST["firstname"])){?>value="<?PHP echo $_POST["firstname"]."\""; }?>>
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Second Name</span>
     <input type="text" class="form-control" placeholder="Second Name" aria-describedby="basic-addon1" name="secondname" 
     <?PHP if(isset($_POST["secondname"])){?>value="<?PHP echo $_POST["secondname"]."\""; }?>>
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">E-Mail</span>
     <input type="text" class="form-control" placeholder="E-Mail Address" aria-describedby="basic-addon1" name="email" 
     <?PHP if(isset($_POST["email"])){?>value="<?PHP echo $_POST["email"]."\""; }?>>
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
     <input type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" name="password">
   </div>
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:120px;text-align:left;">Password</span>
     <input type="password" class="form-control" placeholder="Repeat Password" aria-describedby="basic-addon1" name="password2">
   </div>
   <div align="right">
      <button style="margin:10px;align:right;" class="btn btn-default" type="submit" >
       <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Sign Up
      </button>
   </div>
</div>
</form>