<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php
if (!logged_in()) {
    set_message("<p class='bg-danger'>Please login again to view that page<p>");
    redirect("login.php");
}
$id = $_SESSION['id'];
$phase = getProfPhase($id);
$projects = getParticularProfProjects($id,$phase);

?>
<div class="container">
    <h1>Projects</h1>
    <?php foreach ($projects as $project) {
        $title = getProjectTitle($project['project_id']);
        print_r($title);
        $proj_id = $project['project_id'];
        $students = getStudentsInPhase($id,$phase,$proj_id);
    ?>
        <?php if (count($students) !== 0) : ?>
            <h3><?php echo $title ?></h3>
            <ul class="list-group">
                <?php foreach ($students as $student) : ?>
                    <button type="button" class="list-group-item list-group-item-action"><?php echo $student['first_name']."  ".$student['last_name'] ; ?></button>
                <?php endforeach; ?>
            <?php endif ?>
            </ul>
        <?php } ?>
</div>