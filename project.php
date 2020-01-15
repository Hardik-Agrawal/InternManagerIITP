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
?>
<div style="height: 5vh"></div>
<div class="container">
    <?php foreach ($projects as $project) { ?>
        <div class="card">
            <h5 class="card-header"><?php echo $project['title'] ?></h5>
            <div class="card-body">
                <h5>Title <?php echo $project['title']  ?></h5>
                <p class="card-text"><?php echo $project['description'] ?></p>
                <h5>Abstract : <?php echo $project['abstract']; ?></h5>
                <h5>Deparment : <?php echo $project['department']; ?></h5>
                <h5>Skills : <?php $project['skills'] ?></h5>
                <h5>Project-Wepage : <a href=<?php echo $project['project_webpage'] ?>>Project Webpage</a></h5>
                <h5> Faculty-Wepage : <a href=<?php echo $project['faculty_webpage'] ?>>Faculty Webpage</a></h5>
            </div>
            <br />
        <?php } ?>
        </div>
        <?php include('includes/footer.php') ?>