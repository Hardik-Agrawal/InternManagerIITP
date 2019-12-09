<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php 
	if(logged_in()) {
		redirect("admin.php");
	}
?>

<div class="container">
	<div class="row d-flex justify-content-center" style="margin-top: 50px">
		<div class="col-lg-6">
			<?php validate_user_registration(); ?>
		</div>
	</div>
	<div class="row d-flex justify-content-center">	

		<div class="col-md-6">
			<div class="row" style="margin-bottom: 20px">
				<div class="col-6 mr-0 pr-0">
					<a href="register.php" class="btn btn-success" style="width: 100%">Register</a>
				</div>
				<div class="col-6 ml-0 pl-0">
					<a href="login.php" class="btn btn-secondary" style="width: 100%">Login</a>
				</div>
			</div>

			<div>
				<form id="register-form" method="post" role="form" style="padding: 10px; border: 1px solid rgba(0,0,0,.3); border-radius: 10px">
					<div class="form-group">
						<input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" value="" required >
					</div>
					<div class="form-group">
						<input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name" value="" required >
					</div>
					<div class="form-group">
						<select class="form-control" name="type" id="type" required>
							<option value="" disabled selected>Choose your option</option>
							<option value="1">Faculty</option>
							<option value="2">Student</option>
						</select>
					</div>
					<div class="form-group">
						<select class="form-control" name="gender" id="gender" required>
							<option value="" disabled selected>Choose your gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>
					<div class="form-group">
						<input type="email" name="email" id="register_email" class="form-control" placeholder="Email Address" value="" required >
					</div>
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
					</div>
					<div class="form-group">
						<input type="password" name="confirm_password" id="confirm-password" class="form-control" placeholder="Confirm Password" required>
					</div>
					<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-primary" value="Register Now">
				</form>
			</div>
		</div>
	</div>
</div>
<?php include('includes/footer.php') ?>