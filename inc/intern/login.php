<form action="intern.php?p=login" method="POST">
<div style="width:300px;">
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:100px;text-align:left;">Username</span>
     <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="username" <?PHP if(isset($_SESSION["username"])){ echo 'value="'.$_SESSION["username"].'"'; }?>>
   </div>

   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:100px;text-align:left;">Password</span>
     <input type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" name="password">
   </div>
   <div class="input-group" style="margin:10px;">
      <span class="input-group-addon">
        <input name="remember" type="checkbox" aria-label="..." />
      </span>
      <input type="text" class="form-control" aria-label="..." value="Remember my login" readonly />
    </div>
    
   <div align="right">
      <span class="timeleft"></span><button id="buttonlogin" style="margin:10px;align:right;" class="buttonlogin btn btn-default" name="submit" type="submit" >
       <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Login
      </button>
   </div>
</div>
</form>