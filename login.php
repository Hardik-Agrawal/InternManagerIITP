<?php include('includes/header.php') ?>
<?php include('includes/nav.php') ?>
<?php
if (logged_in()) {
	
	redirect("admin.php");
}
?>

<div class="container">
	<div class="row d-flex justify-content-center" style="margin-top: 50px">
		<div class="col-lg-6">
			<?php display_message(); ?>
			<?php validate_user_login(); ?>
		</div>
	</div>
	<div class="row d-flex justify-content-center">

		<div class="col-md-6">
			<div class="row" style="margin-bottom: 20px">
				<div class="col-6 mr-0 pr-0">
					<a href="register.php" class="btn btn-secondary" style="width: 100%">Register</a>
				</div>
				<div class="col-6 ml-0 pl-0">
					<a href="login.php" class="btn btn-success" style="width: 100%">Login</a>
				</div>
			</div>

			<div>
				<form id="login-form" method="post" role="form" style="padding: 10px; border: 1px solid rgba(0,0,0,.3); border-radius: 10px">
					<div class="form-group">
						<input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
					</div>
					<div class="form-group">
						<input type="password" name="password" id="login-password" class="form-control" placeholder="Password" required>
					</div>
					<div class="form-group text-center">
						<input type="checkbox" name="remember" id="remember">
						<label for="remember"> Remember Me</label>
					</div>
					<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-primary" value="Log In">

					<div class="form-group">
						<div class="row">
							<div class="col-lg-12">
								<div class="text-center">
									<a href="recover.php" tabindex="5" class="forgot-password">Forgot Password?</a>
								</div>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>

<?php include('includes/footer.php') ?>