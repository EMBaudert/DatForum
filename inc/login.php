<form action="intern.php?p=login" method="POST">
<div style="width:300px;">
   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:100px;text-align:left;">Username</span>
     <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="username" <?PHP if(isset($_POST["username"])){?>value="<?PHP echo $_POST["username"]."\" "; }?>>
   </div>

   <div class="input-group" style="margin:10px;">
     <span class="input-group-addon" id="basic-addon1" style="width:100px;text-align:left;">Password</span>
     <input type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" name="password">
   </div>
   <div align="right">
      <button style="margin:10px;align:right;" class="btn btn-default" name="submit" type="submit" >
       <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Login
      </button>
   </div>
</div>
</form>