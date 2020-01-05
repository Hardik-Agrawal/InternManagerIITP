
<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<!DOCTYPE html>
<html>
 <head>
  <title>How to Store Form data in CSV File using PHP</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
   <div class="row">
    <h2 align="center">Project details</h2>
     <br />
     <div class="col-md-6" style="margin:0 auto; float:none;">
      <span id="success_message"></span>
      <form method="post" id="programmer_form" action="">
       <div class="form-group">
       <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" style="width: 60%">
       </div>
       <div class="form-group">
       <label>Enter description</label><br>
       <textarea name="des" id="des" form="projectForm" style="width: 60%; height: 200px;"></textarea>
        </div>
       <div class="form-group">
        <label>Enter your Skill</label>
        <input type="text" name="skill" id="skill" class="form-control" />
       </div>
       <div class="form-group">
        <input type="submit" name="submitProj" id="submit" class="btn btn-info" value="Submit" />
       </div>
      </form>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>



<script>
$(document).ready(function(){
 
 $('#skill').tokenfield({
  autocomplete:{
   source: ['ML','android','web dev','iot','cyber security'],
   delay:100
  },
  showAutocompleteOnFocus: true
 });

 $('#programmer_form').on('submit', function(event){
  event.preventDefault();
  if($.trim($('#title').val()).length == 0)
  {
   alert("Please Enter Title");
   return false;
  }
  else if($.trim($('#skill').val()).length == 0)
  {
   alert("Please Enter Atleast one Skill");
   return false;
  }
  else
  {
   var form_data = $(this).serialize();
   $('#submit').attr("disabled","disabled");
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    beforeSend:function(){
     $('#submit').val('Submitting...');
    },
    success:function(data)
    {
     if(data != '')
     {
      $('#name').val('');
      $('#skill').tokenfield('setTokens',[]);
      $('#success_message').html(data);
      $('#submit').attr("disabled", false);
      $('#submit').val('Submit');
     }
    }
   });
   setInterval(function(){
    $('#success_message').html('');
   }, 5000);
  }
 });
 
});
</script>
