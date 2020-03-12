<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php
$select = "SELECT * FROM projects ORDER BY id";
$res = query($select);
confirm($res);
$projects = array();
while ($row = mysqli_fetch_array($res)) {
    $projects[] = $row;
}
mysqli_free_result($res);
$departments = getDepartments();
$department = 'Chemical';
if (isset($_POST['searchDepartments'])) {
    $department = $_POST['department'];
    $query = "SELECT * FROM projects WHERE department = '$department'";
    $res = query($query);
    confirm($res);
    $projects = array();
    while ($row = mysqli_fetch_array($res)) {
        $projects[] = $row;
    }
    mysqli_free_result($res);
}
?>
<div style="height: 5vh"></div>
<div class="container">
    <form action="" method="POST">
        <label for="department">Select Department</label>
        <select name="department">
            <option value=<?php echo  $department ?>><?php echo $department ?> </option>
            <?php foreach ($departments as $k => $v) : ?>
                <?php if ($v['name'] !== $department) : ?>
                    <option value=<?php echo  $v['name'] ?>><?php echo $v['name'] ?> </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Search" name="searchDepartments">
    </form>
    <?php foreach ($projects as $project) { ?>
        <div class="card">
            <h5 class="card-header"><?php echo $project['title'] ?></h5>
            <div class="card-body">
                <h5>Title <?php echo $project['title']  ?></h5>
                <p class="card-text"><?php echo $project['description'] ?></p>
                <h5>Abstract : <?php echo $project['abstract']; ?></h5>
                <h5>Department : <?php echo $project['department']; ?></h5>
                <h5>Skills : <?php $project['skills'] ?></h5>
                <h5>Project-Wepage : <a href=<?php echo $project['project_webpage'] ?>>Project Webpage</a></h5>
                <h5> Faculty-Wepage : <a href=<?php echo $project['faculty_webpage'] ?>>Faculty Webpage</a></h5>
            </div>
            <br />
        <?php } ?>
        </div>
        <?php include('includes/footer.php') ?>