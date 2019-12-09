<?php include('includes/header.php') ?>

<div class="container">
	<div class="row d-flex justify-content-center" style="margin-top: 50px">
		<div class="col-lg-6">
			<?php display_message(); ?>
			<?php password_reset(); ?>
		</div>
	</div>
	<div class="row d-flex justify-content-center">	

		<div class="col-md-6">
			<div>
				<form id="register-form" method="post" role="form" style="padding: 10px; border: 1px solid rgba(0,0,0,.3); border-radius: 10px">
					<h3 class="text-center text-danger"><b>Reset Password</b></h3>
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
					</div>
					<div class="form-group">
						<input type="password" name="confirm_password" id="confirm-password" class="form-control" placeholder="Confirm Password" required>
					</div>
					<input type="submit" name="reset-password-submit" id="reset-password-submit" class="form-control btn btn-primary" value="Reset Password">
					<a href="login.php" class="btn btn-light">Back to login</a>
					<input type="hidden" class="hide" name="token" id="token" value="<?php echo token_generator(); ?>">
				</form>
			</div>
		</div>
	</div>
</div>

<?php include('includes/footer.php') ?>