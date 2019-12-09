<?php include('includes/header.php') ?>

<div class="container">
	<div class="row d-flex justify-content-center" style="margin-top: 50px">
		<div class="col-lg-6">
			<?php display_message(); ?>
			<?php validate_code(); ?>
		</div>
	</div>
	<div class="row d-flex justify-content-center">	
		<div class="col-md-6">
			<div>
				<form id="code-form"  method="post" role="form" style="padding: 10px; border: 1px solid rgba(0,0,0,.3); border-radius: 10px">
					<h2 class="text-center"><b> Enter Code</b></h2>
					<div class="form-group">
						<input type="text" name="code" id="code" class="form-control" placeholder="******" value="" autocomplete="off" required/>
					</div>
					<div class="form-group">
						<input type="submit" name="code-cancel" id="code-cancel" class="form-control btn btn-success" value="Send" />
					</div>
					<a href="login.php" class="btn btn-light">Cancel</a>
					<input type="hidden" class="hide" name="token" id="token" value="">
				</form>
			</div>
		</div>
	</div>
</div>

<?php include('includes/footer.php') ?>