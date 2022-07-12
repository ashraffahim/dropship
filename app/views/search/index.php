<div class="container-fluid feed">

	<div class="row">

		<!-- Start Filter form -->
		<div class="col-md-2 text-muted">
			<form action="/search" enctype="xxx-http-urlencode">
				<div class="row">
					<div class="col-12">
						<label>Keyword</label>
						<div class="form-group">
							<input type="text" class="form-control border-0 bg-white" value="<?php echo $data['q']; ?>" readonly>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div>Price Range</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<input type="text" name="pmin" class="form-control bg-light" placeholder="Min" value="<?php echo $data['pmn']; ?>">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<input type="text" name="pmax" class="form-control bg-light" placeholder="Max" value="<?php echo $data['pmx']; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<div>Country</div>
						</div>
						<div class="form-group">
							<label for="country_bd" class="d-flex align-items-center">
								<input type="checkbox" id="country_bd" name="country" value="BD" class="mr-1"> Bangladesh
							</label>
						</div>
						<div class="form-group">
							<label for="country_ae" class="d-flex align-items-center">
								<input type="checkbox" id="country_ae" name="country" value="AE" class="mr-1"> United Arab Emirates
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<button class="btn btn-dark btn-block">Filter</button>
						</div>
					</div>
				</div>
			</form>
		</div>

		<!-- End Filter form -->

		<div class="col-md-10">
			<div class="row feed-items">
				<?php
				foreach ($data['data'] as $i => $p) {
				?>
				<div class="col-lg-3 col-md-5 col-sm-6">
					<a href="<?php echo BASEDIR.'/'.$p->id; ?>">
						<div class="card">
							<div class="card-thumb">
								<?php
								$fs = glob(DATADIR.DS.'product'.DS.$p->id.DS.'*');
								if (isset($fs[0])) {
									echo '<img src="'.DATA.DS.'product'.DS.$p->id.DS.basename($fs[0]).'" alt="'.$p->p_name.'" loading="lazy">';
								}
								?>
							</div>
							<div class="card-body">
								<h3 class="lead"><?php echo $p->p_name; ?></h3>
								<div><span class="fct"><?php echo $p->currency_symbol . $p->p_price; ?></span></div>
								<div class="text-muted"><?php echo $p->p_description; ?></div>
							</div>
						</div>
					</a>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
<script>
	let cn = "<?php echo $data['cn']; ?>";
	$('[name="country"][value="' + cn + '"]').attr('checked', '');
</script>