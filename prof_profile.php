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

<div class="container">
	<br />
	<div class="row">
		<div class="col">
			<?php if ($row['gender'] == "Male") { ?>
				<img src="./assets/images/male.png" width="25%" alt="Profile">
			<?php } else { ?>
				<img src="./assets/images/female.png" width="25%" alt="Profile">
			<?php } ?>
		</div>
		<div class="col">
			<p>hhh</p>
			<p>Name: <?php echo "{$row['first_name']} {$row['last_name']}" ?></p>
			<p>Gender: <?php echo "{$row['gender']}" ?></p>
			<a href="./addproject.php" class="btn btn-medium btn-primary">Add Project</a>
		</div>
	</div>
	<br />
</div>
<div class="container">
	<?php foreach ($projects as $project) { ?>
		<div class="card">
			<h5 class="card-header"><?php echo $project['title'] ?></h5>
			<div class="card-body">
				<h5 class="card-title"><?php echo $project['title']  ?></h5>
				<p class="card-text"><?php echo $project['description'] ?></p>
				<a href="#" class="btn btn-primary">More Details</a>
			</div>
		</div>
		<br />
	<?php } ?>
</div>

<?php include('includes/footer.php') ?>