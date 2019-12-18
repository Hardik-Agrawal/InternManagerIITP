<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php
if (!logged_in()) {
    set_message("<p class='bg-danger'>Please login again to view that page<p>");
    redirect("login.php");
}
$row = getUserDetails($_SESSION['email']);
$projects = getProfProjects($_SESSION['email']);
?>
<!-- <a href="./prof_profile.php" class="btn btn-warning btn-medium">Back to Profile</a> -->
<div class="container">

    <div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            add_project($_SESSION['email'], $_POST['title'], $_POST['des']);
        }
        ?>
    </div>
    <form action="./addproject.php" id="projectForm" method="POST">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" style="width: 60%">
        </div>
        <textarea name="des" id="des" form="projectForm" style="width: 60%; height: 200px;"></textarea>
        <br>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>

</div>

<?php include('includes/footer.php') ?>