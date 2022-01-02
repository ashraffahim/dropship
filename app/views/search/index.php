<div class="container-fluid">
	<div class="row">
		<?php
		if ($data['data']) {
		?>
		<div class="col-md-10 offset-md-2">
			<div class="row">
				<?php
				foreach ($data['data'] as $i => $p) {
				?>
				<div class="col-lg-3 col-md-5 col-sm-6 hfpc">
					<a href="<?php echo BASEDIR.'/'.$p->p_handle; ?>">
						<div class="card border-0">
							<?php
							$fs = glob(DATADIR.DS.'product'.DS.$p->id.DS.'*');
							foreach ($fs as $j => $f) {
								echo '<img src="'.DATA.DS.'product'.DS.$p->id.DS.basename($f).'" alt="'.$p->p_name.'">';
								if ($j == 1) break;
							}
							?>
							<div class="card-body">
								<h3 class="lead"><?php echo $p->p_name; ?></h3>
								<div><i class="sr5"></i></div>
								<div><span class="text-success lead">$<?php echo $p->p_price; ?></span></div>
							</div>
						</div>
					</a>
				</div>
				<?php
				}
				?>
			</div>
		</div>
		<?php
		} else {
		?>
		<div class="col-12 text-center">
			<img src="/assets/img/no-data.png" alt="No Data" height="400">
			<h1 class="display-4">We're sorry to let you down!</h1>
		</div>
		<?php
		}
		?>
	</div>
</div>