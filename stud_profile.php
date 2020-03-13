<?php include('includes/header.php') ?>
<link rel="stylesheet" href="./css/stud.css">
<?php include('includes/nav.php') ?>
<?php

if (!logged_in()) {
	set_message("<p class='bg-danger'>Please login again to view that page<p>");
	redirect("login.php");
}
$row = getStudentDetails($_SESSION['email']);
require './imageUpload.php';
require './resumeUpload.php';
if (isset($_POST['dataEnter'])) {
	if (isset($_POST['collegeName']))
		setCollegeName($row['email'], $_POST['collegeName']);
	if (isset($_POST['description']))
		setDescription($row['email'], $_POST['description']);
}
$temp = getAllProfProjects($row['email']);
$error = '';
$projectCount  = getProjectCount($row['email']) + 1;
if (isset($_POST['submitProj'])) {
	$email = $_SESSION['email'];
	foreach ($temp as $k => $v) {
		if (isset($_POST[$v[0]])) {
			insertInPrefrences($projectCount, $_SESSION['id'], $v[0]);
			$var = "project" . $projectCount . "_id";
			// print_r($var);
			$query = "UPDATE students SET $var = '$v[0]'  WHERE email = '$email';";
			$res = query($query);
			confirm($res);
			$query = "UPDATE students SET projectSelected = '$projectCount' WHERE email = '$email';";
			$res = query($query);
			confirm($res);
			$error = "Succesfully submitted your response";
			$temp = getAllProfProjects($row['email']);
			$projectCount  = getProjectCount($row['email']) + 1;
			$row = getStudentDetails($_SESSION['email']);
		}
	}
}
$projects = array($row['project1_id'], $row['project2_id'], $row['project3_id'], $row['project4_id']);
$projectNames = array();
foreach ($projects as $val) {
	array_push($projectNames, getProjectName($val));
}
?>
<div class="container-fluid">
	<?php if ($resumeUploadError !== 'Successfully Uploaded' && $resumeUploadError !== '') : ?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<?php echo $resumeUploadError ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php elseif ($resumeUploadError !== '') : ?>
		<div class="alert alert-info alert-dismissible fade show" role="alert">
			<?php echo $resumeUploadError ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>
	<div class="row">
		<h1>Student Profile</h1>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

			<div class="card" style="width: 18rem;">
				<?php if ($row['imageName'] === '') : ?>
					<img class="card-img-top" src='./assets/images/male.png' alt="Card image cap">
				<?php else : ?>
					<img class="card-img-top" src='./uploads/studentImages/<?php echo $row['imageName'] ?>' alt="Card image cap">
				<?php endif; ?>
				<div class="card-body">
					<h5 class="card-title"><?php echo implode(' ', array($row['first_name'], $row['last_name'])) ?></h5>
					<?php if ($row['college'] != '') : ?>
						<p class="card-text">College : <?php echo $row['college'] ?></p>
					<?php endif; ?>
					<?php if ($row['imageName'] === '') : ?>
						<form action="" method="post" enctype="multipart/form-data">
							<div class="form-group">
								Upload an Image:
								<input type="file" name="myfile" id="fileToUpload" class="form-control">
								<input type="submit" name="submitImage" value="Upload File Now" class="form-control btn btn-primary">
							</div>
						</form>
					<?php else : ?>
						<!-- <div class="form-group">
							change uploaded Image:
							<input type="file" name="myfile" id="fileToUpload" class="form-control">
							<input type="submit" name="submitImage" value="Upload File Now" class="form-control btn btn-primary">
						</div> -->
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<?php if ($row['college'] === '' || $row['description'] === '') : ?>
				<form action="" method="POST">
					<div class="form-group">
						<?php if ($row['college'] === '') : ?>
							<label for="Enter College">Enter College Name</label>
							<input type="text" name="collegeName" class="form-control">
						<?php endif; ?>
						<?php if ($row['description'] === '') : ?>
							<label for="Enter College">Enter Something about yourself</label>
							<textarea class="form-control" rows="5" id="comment" name="description"></textarea>
						<?php endif; ?>
						<input type="submit" name="dataEnter" class="btn btn-primary form-comtrol">
					</div>
				</form>
			<?php else : ?>
				<?php if ($row['college'] != '') : ?>
					<h3>College: <?php echo $row['college'] ?></h3>
				<?php endif; ?>
				<?php if ($row['description'] != '') : ?>
					<h3>Description:</h3>
					<p><?php echo $row['description'] ?></p>
				<?php endif; ?>
			<?php endif; ?>
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<?php if ($row['resumeName'] == '') : ?>
						Upload the resume:
						<input type="file" name="myfile" id="fileToUpload" class="form-control">
						<input type="submit" name="submitResume" value="Upload File Now" class="form-control btn btn-primary">
					<?php endif; ?>
				</div>
			</form>
		</div>
	</div>
	<?php if ($row['projectSelected'] != 4) : ?>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<h1>Select Projects</h1>
				<?php if ($error != '') : ?>
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<?php echo $error ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<h1>Select preference <?php echo $projectCount ?></h1>
				<form action="" method="POST">
					<div class="form-group">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th scope="col">Select</th>
									<th scope="col">Name</th>
									<th scope="col">Description</th>
									<th scope="col">Project Website</th>
									<th scope="col">Professor Website</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($temp as $key => $val) : ?>
									<tr>
										<td><input type="checkbox" name=<?php echo $val[0] ?> class="ProgCheck" onclick="onlyOne(this)"></td>
										<td><?php echo $val['title'] ?></td>
										<td><?php echo $val['description'] ?></td>
										<td><a href='<?php echo $val['project_webpage'] ?>'></a><?php echo $val['project_webpage'] ?></td>
										<td><a href='<?php echo $val['faculty_webpage'] ?>'></a><?php echo $val['faculty_webpage'] ?></td>

									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<input type="submit" name="submitProj" class="btn btn-primary">
				</form>
			</div>
		</div>
	<?php else : ?>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8">
				<h1>Chosen Projects</h1>
				<div class="list-group">
					<?php foreach ($projectNames as $name) :  ?>
						<a href="#" class="list-group-item list-group-item-action ">
							<?php echo $name ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>

<script src="./functions/javascript/onlyone.js"> </script>
<?php include('includes/footer.php') ?>