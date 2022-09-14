<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Login | Dropship</title>
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
	<main class="login-main">
		<div class="container">
			<div class="row justify-content-end align-items-center" style="height: 100vh">
				<div class="col-lg-5 col-md-7 col-sm-9">
					<div class="card shadow-sm">
						<div class="card-body">
							
							<div class="row mb-3">
								<div class="col-12">
									<h5 class="text-center">Welcome Back</h5>
								</div>
							</div>

							<?php
							if ($data['status'] === 0) {
							?>
							<div class="row mb-3">
								<div class="col-12">
									<div class="card-tag-danger">
										<div><i class="fal fa-exclamation-triangle"></i></div>
										<div class="ml-3"><b>Wrong credentials!</b></div>
									</div>
								</div>
							</div>
							<?php
							}
							?>

							<form method="post">
								<div class="row">
									<div class="col-12">
										<div class="form-group">
											<input type="text" name="email" class="form-control" placeholder="Email">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<div class="form-group">
											<input type="password" name="password" class="form-control" placeholder="Password">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6 d-flex">
										<div><input type="checkbox" name="remember" class="mt-1"></div>
										<div class="ml-1">Remember</div>
									</div>
									<div class="col-6">
										<button type="submit" class="btn btn-theme btn-block">Login</button>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<hr>
									</div>
								</div>
								<div class="row">
									<div class="col-12 text-center text-muted">
										Don't have an account? <a href="/signup">Signup</a>
									</div>
								</div>
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