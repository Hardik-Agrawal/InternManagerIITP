<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php
if (!logged_in()) {
	set_message("<p class='bg-danger'>Please login again to view that page<p>");
	redirect("login.php");
}
$row = getUserDetails($_SESSION['email']);
require './projectFileUpload.php';
$projects = getProfProjects($_SESSION['id']);
if (isset($_POST['submitPDF'])) {
	uploadPDF($_POST['id'], $_FILES);
}
?>

<?php if ($projectUploadError !== 'Successfully Uploaded' && $projectUploadError !== '') : ?>
	<div class="alert alert-warning alert-dismissible fade show" role="alert">
		<?php echo $projectUploadError ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php elseif ($projectUploadError !== '') : ?>
	<div class="alert alert-info alert-dismissible fade show" role="alert">
		<?php echo $projectUploadError ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif; ?>

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
				<h5>Title <?php echo $project['title']  ?></h5>
				<p class="card-text"><?php echo $project['description'] ?></p>
				<h5>Abstract : <?php echo $project['abstract']; ?></h5>
				<h5>Deparment : <?php echo $project['department']; ?></h5>
				<h5>Skills : <?php $project['skills'] ?></h5>
				<h5>Project-Wepage : <a href=<?php echo "https://" . $project['project_webpage'] ?> target="_blank">Project Webpage</a></h5>
				<h5> Faculty-Wepage : <a href=<?php echo "https://" . $project['faculty_webpage'] ?> target="_blank">Faculty Webpage</a></h5>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<?php if ($project['pdfName'] == '') : ?>
							<input type="text" name="id" style="display:none" value=<?php echo $project['id']  ?>>
							Upload pdf for the project
							<input type="file" name="myfile" id="fileToUpload" class="form-control">
							<input type="submit" name="submitProgPdf" value="Upload File Now" class="form-control btn btn-primary">
						<?php else : ?>
							<a class="btn btn-warning" href="./projectFileDownload.php?id=<?php echo $project["id"] ?>" target="_blank">Download File</a>
						<?php endif; ?>
					</div>
				</form>
			</div>
		</div>
		<br />
	<?php } ?>
</div>

<?php include('includes/footer.php') ?>