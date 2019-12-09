<?php include('includes/header.php') ?>

<div class="container">
	<div class="row d-flex justify-content-center" style="margin-top: 50px">
		<div class="col-lg-6">
			<?php display_message(); ?>
			<?php recover_password(); ?>
		</div>
	</div>
	
	<div class="row d-flex justify-content-center">	
		<div class="col-md-6">
			<div>
				<form id="register-form"  method="post" role="form" autocomplete="off" style="padding: 10px; border: 1px solid rgba(0,0,0,.3); border-radius: 10px">
					<h2 class="text-center"><b>Recover Password</b></h2>
					<hr>
					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control" placeholder="Email Address" value="" autocomplete="off" />
					</div>
					<div class="form-group">
						<input type="submit" name="recover-submit" id="recover-submit" class="form-control btn btn-success" value="Send Password Reset Link" />
					</div>
					<a href="login.php" class="btn btn-light">Cancel</a>
					<input type="hidden" class="hide" name="token" id="token" value="<?php echo token_generator(); ?>">	
				</form>
			</div>
		</div>
	</div>
</div>


<?php include('includes/footer.php') ?>