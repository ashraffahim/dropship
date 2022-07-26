<div class="container-fluid product-details">
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="card shadow-sm">
				<div class="card-body">
					<div class="row">

						
						<!-- Left Column -->
						
						<div class="col-md-6">
							<div class="row">
								<div class="col-12">
									<div class="crsl">
										<div class="crslc">
											<?php
											$fs = glob(DATADIR . DS . 'product' . DS . $data['data']->id . DS . '*');
											foreach ($fs as $f) {
											?>
											<div class="crsli">
												<img src="<?php echo DATA . DS . 'product' . DS . $data['data']->id . DS . basename($f); ?>" alt="<?php echo $data['data']->p_name; ?>">
											</div>
											<?php
											}
											?>
										</div>
										<div class="crslp"><i class="fal fa-arrow-left"></i></div>
										<div class="crsln"><i class="fal fa-arrow-right"></i></div>
									</div>
								</div>
							</div>
						</div>
						
						
						<!-- Right Column -->

						<div class="col-md-6">
							<div class="row mb-3">
								<div class="col-lg-5">
									<div class="row">
										<div class="col-12">
											<h1 class="_pn">
												<?php echo $data['data']->p_name; ?>
											</h1>
											<h5 class="text-muted ff2">
												<?php echo $data['data']->p_category; ?>
											</h5>
										</div>
										<div class="col-12 mb-3">
											<div class="lead fct"><?php echo $data['curr'] . '<span class="_pp">' . number_format($data['data']->p_price) . '</span>'; ?></div>
										</div>
									</div>
								</div>
								<div class="col-lg-7">
									<div class="row h-100 align-items-center">
										<div class="col-6">
											<button type="button" class="btn btn-outline-secondary btn-block add-to-cart" data-id="<?php echo $data['data']->id; ?>">Add to Cart</button>
										</div>
										<div class="col-6">
											<button type="button" class="btn btn-theme btn-block buy" data-id="<?php echo $data['data']->id; ?>">Buy</button>
										</div>
									</div>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-12">
									<div class="text-muted">
										<?php echo nl2br($data['data']->p_description); ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<h5>Custom Specs</h5>
								</div>
								<div class="col-lg-6">
									<table class="table table-sm table-hover ff3 text-muted">
										<?php
										$jd = json_decode($data['data']->p_custom_field);
										foreach ($jd as $f => $v) {
										?>
										<tr>
											<th><?php echo $f; ?></th>
											<td><?php echo $v; ?></td>
										</tr>
										<?php
										}
										?>
									</table>
								</div>
							</div>
						</div>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>crsl();allowAddToCart('.add-to-cart');allowAddToCart('.buy', () => {location.href = '/cart';});</script>