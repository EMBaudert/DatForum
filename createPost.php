<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Summernote</title>
  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
</head>
<body>
   <div class="container">
   
      <?php
         require_once('inc/navbar.php');
      ?>
   
      <div class="row">
         <div id="summernote">
            <p>Hello Summernote</p>
         </div>
         
         <div class="btn-group pull-right" role="group">
             <a class ="btn btn-default" id="target"><span class="glyphicon glyphicon-envelope"></span> Abschicken!</a>
         </div>
      </div>
   </div>
  
  <script>
    $(document).ready(function() {
        $('#summernote').summernote();
        
         $('#target').button().click(function(){
            var markupStr = $('#summernote').summernote('code');
            
            alert(markupStr);
         });    
    });
    
   
  </script>
  
    <?php
         include_once('inc/navbar.php');
      ?>
</body>
</html>