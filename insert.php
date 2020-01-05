
<?php
//insert.php

if(isset($_POST["name"]))
{
 $query = "INSERT INTO `projects` (title, skill) VALUES('$sta', )";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST["title"],
   ':skill' => $_POST["skill"]
  )
 );
 $result = $statement->fetchAll();
 $output = '';
 if(isset($result))
 {
  $output = '
  <div class="alert alert-success">
   Your data has been successfully saved into System
  </div>
  ';
 }
 echo $output;
}

?>
