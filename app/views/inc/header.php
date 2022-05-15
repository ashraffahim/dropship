<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $data['title']; ?></title>
	<meta name="description" content="<?php echo $data['description']; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- style -->
	<!-- build:css /assets/css/site.min.css -->
	<link rel="stylesheet" href="/libs/font-awesome/css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="/assets/css/bootstrap.css" type="text/css">
	<link rel="stylesheet" href="/assets/css/style.css" type="text/css">
	<!-- endbuild -->
	<link rel="canonical" href="<?php echo $data['canonical']; ?>">
	<link rel="manifest" href="/manifest.json">
	<script type="application/ld+json"><?php echo $data['schema']; ?></script>
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
		<nav class="navbar mb-5">
			<div class="container">
				<div class="col-2">
					<a href="/">
						<div style="display: inline-block;height: 34px;width: 64px;background-image: url(<?php echo LOGO; ?>);background-size: cover;"></div>
					</a>
				</div>
				<div class="col-md-6 col-10">
					<form enctype="xxx-http-urlencode" action="search" class="d-flex">
						<div class="input-group">
							<input type="search" name="q" placeholder="Search" class="form-control border-0">
							<div class="input-group-append">
								<button class="btn bg-white"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-4"></div>
			</div>
		</nav>