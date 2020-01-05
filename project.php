<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php
$select = "SELECT * FROM projects ORDER BY id";
$pro = mysqli_query($con, $select);
// $pro = query($select);
?>

<div style="height: 5vh"></div>
<div class="container">
    <?php foreach ($pro as $project) { ?>
        <div class="card">
            <h5 class="card-header"><?php echo "<span>$project[id]</span>: <span>$project[title]</span>" ?></h5>
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