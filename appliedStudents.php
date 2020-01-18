<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php
if (!logged_in()) {
    set_message("<p class='bg-danger'>Please login again to view that page<p>");
    redirect("login.php");
}
$id = $_SESSION['id'];
updatePhase($id);
$phase = getProfPhase($id);
$projects = array();

if ($phase != 0) {
    $projects = getParticularProfProjects($id, $phase);
}
if(isset($_POST['selectStudent'])) {
    $student_id = $_POST['id'];
    $proj_id = $_POST['proj_id'];
    $query = "UPDATE students SET selected = 1,proj_id = '$proj_id',prof_id='$id' WHERE id = '$student_id'";
    $res = query($query);
    confirm($res);
    for($i = 1;$i<=4;$i++) {
    $query = "DELETE FROM prefrence_$i WHERE student_id = '$student_id'";
    $res = query($query);
    confirm($res);
    }
    $query = "SELECT email FROM students WHERE id = '$student_id'";
    $res = query($query);
    confirm($res);
    $row = fetch_array($res);
    $email = $row['email'];
    $subject = "You have been selected";
    $msg = "Intern mil gayi";
    $headers = "";
    send_email($email,$subject,$msg,$headers); 
}
?>
<div class="container">
    <?php if ($phase === 0) : ?>
        <h1>Selection Phase Over</h1>
    <?php else : ?>
        <h1>Projects</h1>
        <?php foreach ($projects as $project) {
            $title = getProjectTitle($project['project_id']);
            print_r($title);
            $proj_id = $project['project_id'];
            $students = getStudentsInPhase($id, $phase, $proj_id);
        ?>
            <?php if (count($students) !== 0) : ?>
                <h3><?php echo $title ?></h3>
                <ul class="list-group">
                    <?php foreach ($students as $student) : ?>
                        <form action="" method="POST">
                        <p type="button" class="list-group-item list-group-item-action"><?php echo $student['first_name'] . "  " . $student['last_name']; ?>
                            <input type="text" value=<?php echo $student['id'] ?> style = "display:none;" name="id">
                            <input type="text" value=<?php echo $proj_id ?> style = "display:none;" name="proj_id"> 
                            <input type="submit" value="Select" name="selectStudent" class="btn btn-primary">
                        </p>
                        </form>
                    <?php endforeach; ?>
                <?php endif ?>
                </ul>
            <?php } ?>
        <?php endif; ?>
</div>