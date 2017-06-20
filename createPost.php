<!DOCTYPE html>
<html lang="en">
   <head>
     <meta charset="UTF-8">
     <title>Summernote</title>
     
     <!-- Das neueste kompilierte und minimierte CSS -->
      <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap.min.css">

      <!-- Optionales Theme -->
      <link rel="stylesheet" href="bootstrap/less/dist/css/bootstrap-theme.min.css">

      <link rel="stylesheet" href="layout/style.css">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="bootstrap/less/dist/js/bootstrap.min.js" ></script>
     
     
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
         include_once('inc/footer.html');
      ?>
   </body>
</html>