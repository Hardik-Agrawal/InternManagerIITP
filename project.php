<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php
$select = "SELECT * FROM projects ORDER BY id";
$res = query($select);
confirm($res);
$projects = array();
while($row = mysqli_fetch_array($res)){
    $projects[] = $row;
}
mysqli_free_result($res);
?>

<div style="height: 5vh"></div>
<div class="container">
    <?php foreach ($projects as $project) { ?>
        <div class="card">
            <h5 class="card-header"><?php echo '<span>'.$project['id'].'</span>: <span> '. $project['title'].'</span>' ?></h5>
            <div class="card-body">
                <!-- <h5 class="card-title"><?php echo $project['title']  ?></h5> -->
                <p class="card-text"><?php echo $project['description'] ?></p>
                <a href="#" class="btn btn-primary">More Details</a>
                <button class="btn btn-secondary" style="margin: 0 5px">Register</button>
            </div>
        </div>
        <br />
    <?php } ?>
</div>
<?php include('includes/footer.php') ?>