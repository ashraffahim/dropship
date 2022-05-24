<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Signup | Dropship</title>
	<meta name="description" content="Signup as buyer to purchase products">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- style -->
	<!-- build:css /assets/css/site.min.css -->
	<!-- <link rel="stylesheet" href="/libs/font-awesome-pro-5/css/free.min.css" type="text/css"> -->
	<link rel="stylesheet" href="/libs/font-awesome-pro-5/css/all.min.css" type="text/css">
	<link rel="stylesheet" href="/assets/css/bootstrap.css" type="text/css">
	<link rel="stylesheet" href="/assets/css/style.css" type="text/css">
	<!-- endbuild -->
	<link rel="canonical" href="/signup">
	<link rel="manifest" href="/manifest.json">
	<!-- Script -->
	<!-- jQuery -->
	<script src="/libs/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="/libs/popper.js/dist/umd/popper.min.js"></script>
	<script src="/libs/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- App -->
	<script src="/assets/js/script.js"></script>
<body>
	<main>
		<div class="container">
			<div class="row justify-content-end align-items-center" style="height: 100vh">
				<div class="col-lg-5 col-md-7 col-sm-9">
					<div class="card shadow-sm">
						<div class="card-body">
							<form method="post">

								<div class="row mb-3">
									<div class="col-12">
										<?php
										if (isset($data['cardTag'])) {
											?>
										<div class="card-tag-<?php echo $data['cardTag']['type']; ?>">
											<div><i class="fal fa-<?php echo $data['cardTag']['icon']; ?>"></i></div>
											<div class="ml-3"><?php echo $data['cardTag']['body']; ?></div>
										</div>
										<?php
										}
										?>
									</div>
								</div>

								<?php if (!isset($_SESSION['vcode'])) : ?>
								<!-- Signup form start -->
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<input type="text" name="first_name" class="form-control" placeholder="First name" required>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<input type="text" name="last_name" class="form-control" placeholder="Last name" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<div class="form-group">
											<input type="text" name="email" class="form-control" placeholder="Email" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<div class="form-group">
											<select name="country" class="custom-select" placeholder="Country" required>
												<option disabled selected>Select country</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<input type="password" name="password" class="form-control" placeholder="Password" required>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<input type="password" class="form-control confirm-password" placeholder="Confirm" required>
										</div>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-6 d-flex">
										<div>
											<input type="checkbox" name="sign" class="mt-1" required>
										</div>
										<div class="ml-1">
											I agree to the <a href="terms-of-user">Terms of use</a> & <a href="privacy-policy">Privacy policy</a>
										</div>
									</div>
									<div class="col-6">
										<button class="btn btn-theme btn-block">Submit</button>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<hr>
									</div>
								</div>
								<div class="row">
									<div class="col-12 text-center text-muted">Already signed up? <a href="/login">Login</a></div>
								</div>

								<!-- Signup form end -->

								<?php else: ?>
								
								<!-- Verification form start -->

								<div class="row mb-3">
									<div class="col-12">
										<div class="form-group">
											<input type="text" name="vcode" class="form-control text-center">
										</div>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-6">
										<button type="button" class="btn btn-block">Resend</button>
									</div>
									<div class="col-6">
										<button type="submit" class="btn btn-theme btn-block">Verify</button>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-12 text-center">
										<a href="/signup/clear-tmp">Cancel</a>
									</div>
								</div>

								<!-- Verification form end -->

								<?php endif; ?>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
</html>
<script>
	var country = '<?php echo $data['country']; ?>'.split(','),
		ccan;
	for (var i = 1; i < country.length; i++) {
		ccan = country[i].split(':');
		$('[name="country"]').append(`<option value="${ccan[0]}">${ccan[1]}</option>`);
	}
</script>