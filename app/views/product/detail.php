<div class="container-fluid" data-plugin="pd">
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<!-- Image section / Long text -->
						<div class="col-md-6">
							<div class="row mb-3">
								<div class="col-10 p-0">
									<div class="sptlt">
									<?php
									$p = $data['data'];
									// spotlight
									echo '<img src="' . $data['fs'][0] . '" alt="'.$p->p_name.'">';
									?>
									</div>
								</div>
								
								<div class="col-1 p-0">
									<div class="glr">
									<?php
									foreach ($data['fs'] as $j => $f) {
										echo '<div class="glri"><img src="' . $f . '" alt="'.$p->p_name.'"></div>';
									}
									?>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12">
								<!-- Long text -->
								<?php
								$cfs = json_decode($p->p_custom_field);
								$st = '';
								
								if ($p->p_description != '') {
									echo '<h3>Description</h3><span>' . $p->p_description . '</span>';
								}
								foreach ($cfs as $f => $v) {
									if (strlen($v) > 20) {
										echo '<h3>' . $f . '</h3><span>' . $v . '</span>';
										continue;
									}
									$st .= '<tr><th>' . $f . '</th><td>' . $v . '</td></tr>';
								}
								?>
								</div>
							</div>
						</div>

						<!-- Text section -->
						<div class="col-md-6">
							<!-- title -->
							<div class="row mb-3">
								<div class="col-6">
									<h1><?php echo $p->p_name; ?></h1>
									<span class="lead">$<?php echo $p->p_price; ?></span>
								</div>
							</div>
							<!-- action -->
							<div class="row mb-3">
								<div class="col-4">
									<a href="tel:<?php echo SALES_TEL; ?>" class="btn btn-light btn-wave btn-block justify-content-between">
										<i data-feather="phone"></i><div><?php echo SALES_TEL; ?></div><div></div>
									</a>
								</div>
								<div class="col-2">
									<button class="btn btn-primary btn-wave btn-block justify-content-between" disabled>
										<div></div><div>Cart</div><i data-feather="shopping-cart"></i>
									</button>
								</div>
							</div>
							<!-- action 2 -->
							<div class="row mb-3">
								<div class="col-6 text-center">
									<a href="mailto:<?php echo SALES_EMAIL; ?>" class="btn btn-outline-light btn-wave btn-block text-dark">
										<?php echo SALES_EMAIL; ?>
									</a>
								</div>
							</div>
							<!-- details -->
							<div class="row">
								<div class="col-6">
									<?php
									if ($st != '') {
										echo '<table class="table table-sm">' . $st . '</table>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>