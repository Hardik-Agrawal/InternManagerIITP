<?php include('includes/header.php') ?>
<link rel="stylesheet" href="./css/stud.css">
<?php include('includes/nav.php') ?>
<?php
if (!logged_in()) {
	set_message("<p class='bg-danger'>Please login again to view that page<p>");
	redirect("login.php");
}
$row = getUserDetails($_SESSION['email']);

?>

<div class="container">
	<div class="row">
		<div class="col">
			<h1 class="text-center">
				<?php
				echo "Hello {$row['first_name']}<br>";
				// echo "Student<br>";
				?>
			</h1>
		</div>
	</div>
</div>
<img src="./assets/images/male.png" alt="male" style="padding: 10px 20px; width:25%">

<div id="data" class="float-right" style="padding: 10px 0;width:70%; text-align:centre">
	<h2>Student Name</h2>
	<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Atque saepe voluptatum iure molestiae possimus consectetur cupidita</p>
	<p>B.Tech 2nd Year</p>
	<p>Branch: Branch</p>
	<p>College: College</p>
</div>

<div class="float-left" style="margin-top: 10vh;width: 20vw">
	<p style="padding: 0 30px">You cannot edit your coices after submitting</p>
	<button class="btn" style="margin: 0 30px">Submit</button>
</div>

<div id="projects" class="float-centre">
	<h2>Project Prefernce</h2>
	<ol>

		<li>
			<a>Project 1</a>
			<button class="btn btn-danger">
				&#x2715;
			</button>
		</li>

		<li>
			<a>Project 2</a>
			<button class="btn btn-danger">
				&#x2715;
			</button>
		</li>

		<li>
			<a>Project 3</a>
			<button class="btn btn-danger">
				&#x2715;
			</button>
		</li>

		<li>
			<a>Project 4</a>
			<button class="btn btn-danger">
				&#x2715;
			</button>
		</li>

	</ol>
</div>

<?php include('includes/footer.php') ?>