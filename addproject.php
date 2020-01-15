<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php $departments = getDepartments();
if(isset($_POST['projectDetails'])){
     enterData($_POST,$_SESSION['id']);
}
?>

<body>
     <div class="container">
          <form action="" method="POST">
               <div class="form-group">
                    <label for="projectTitle">Project Title</label>
                    <input type="text" name="projectTitle" class="form-control" placeholder="Title">
               </div>
               <div class="form-group">
                    <label for="abstract">Abstract</label>
                    <input type="text" name="abstract" placeholder="Abstract" class="form-control">
               </div>
               <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" cols="30" rows="10" placeholder="write something about the project" class="form-control"></textarea>
               </div>
               <div class="form-group">
                    <label for="department">Department</label>
                    <select name="department" class="form-control">
                         <?php foreach ($departments as $k => $v) : ?>
                              <option value=<?php echo strval($v['name']) ?>><?php echo strval($v['name']) ?></option>
                         <?php endforeach; ?>
                    </select>
               </div>
               <div class="form-group">
                    <label for="Skills">Skills</label>
                    <input type="text" name="skills" placeholder="Skills" class="form-control">
               </div>
               <div class="form-group">
                    <label for="project-webpage">Project Webpage</label>
                    <input type="text" name="project_webpage" placeholder="Porject webpage" class="form-control">
               </div>
               <div class="form-group">
                              <label for="faculty_webpage">Faculty Webpage</label>
                              <input type="text" name="faculty_webpage" placeholder="Faculty webpage" class="form-control">
               </div>
               <div class="form-group">
                    <input type="submit" value="Submit" name="projectDetails" class="btn btn-primary">
               </div>
          </form>
     </div>
</body>