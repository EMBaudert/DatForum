
         <div class="row">
            <h2>Thread erstellen</h2>
         </div>
         <div class="row">
            <div class="input-group margin-bottom">
               <span class="input-group-addon">Threadtitel</span>
               <input type="text" class="form-control" id="threadtitle" placeholder="" aria-describedby="threadtitle">
            </div>
         </div>
         <?php if($_GET['type']== 'thread'){ ?>
            <div class="row">
               <trix-editor id="trix"></trix-editor>
            </div>
         <?php } else if($_GET['type']=='menupoint'){ ?>
            <div class="row">
            
            </div>
         <?php } ?>
         <div class="row">
            <a class ="btn btn-default btn-textfield pull-right" id="target"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>
         </div>
         
         <?php
            include_once('inc/footer.html');
         ?>
     