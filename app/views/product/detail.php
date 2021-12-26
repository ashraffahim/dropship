<div class="container-fluid" data-plugin="pd">
	<div class="row">
		<!-- Image section -->
		<div class="col-md-5 offset-md-2">
			<div class="row">
				<div class="col-10 p-0">
					<div class="sptlt">
					<?php
					$p = $data['data'];
					$fs = glob(DATADIR.DS.'product'.DS.$p->id.DS.'*');
					// spotlight
					echo '<img src="'.DATA.DS.'product'.DS.$p->id.DS.basename($fs[0]).'" alt="'.$p->p_name.'">';
					?>
					</div>
				</div>
				
				<div class="col-1 p-0">
					<div class="glr">
					<?php
					foreach ($fs as $j => $f) {
						echo '<div class="glri"><img src="'.DATA.DS.'product'.DS.$p->id.DS.basename($f).'" alt="'.$p->p_name.'"></div>';
					}
					?>
					</div>
				</div>
			</div>
		</div>

		<!-- Text section -->
		<div class="col-md-5">
			<!-- title -->
			<div class="row mb-3">
				<div class="col-6">
					<h1><?php echo $p->p_name; ?></h1>
					<span class="lead">$<?php echo $p->p_price; ?></span>
				</div>
			</div>
			<!-- action -->
			<div class="row mb-3">
				<div class="col-3">
					<button class="btn btn-light btn-wave btn-block justify-content-between">
						<i data-feather="phone"></i><div>Enquire</div><div></div>
					</button>
				</div>
				<div class="col-3">
					<button class="btn btn-primary btn-wave btn-block justify-content-between">
						<div></div><div>Add to cart</div><i data-feather="shopping-cart"></i>
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
					<table class="table table-sm">
					<?php
					$cfs = json_decode($p->p_custom_field);
					foreach ($cfs as $f => $v) {
						echo '<tr><th>' . $f . '</th><td>' . $v . '</td></tr>';
					}
					?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>