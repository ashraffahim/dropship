<div class="container-fluid feed">
	<div class="row">
		<div class="col-md-10 offset-md-2">
			<div class="row">
				<?php
				foreach ($data['data'] as $i => $p) {
				?>
				<div class="col-lg-3 col-md-5 col-sm-6">
					<a href="<?php echo BASEDIR.'/'.$p->id; ?>">
						<div class="card border-0">
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
								<div class="fct lead"><span class="curr-symbol"><?php echo $p->s_country; ?></span><?php echo $p->p_price; ?></div>
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
	var curr = {}, c;
	function replaceWCurrency() {
		$('.curr-symbol').each(function() {
			c = $(this).text();
			if (curr[c] != undefined) {
				$(this).html(curr[c]);
			}
		});
	}

	function loadCurrSymbol() {
		var currGrp = [];
		$('.curr-symbol').each(function() {
			c = $(this).text();
			if (curr[c] == undefined && currGrp[c] == undefined) {
				currGrp[c] = 1;
			}
		});
		$.ajax({
			type: 'GET',
			url: '/country/curr-symbol/' + Object.keys(currGrp).join(',') + '/1',
			success: function(d) {
				d = JSON.parse(d);
				var keys = Object.keys(d);
				for(var i = 0; i < keys.length; i++) {
					curr[keys[i]] = d[keys[i]];
				}
				replaceWCurrency();
			}
		});
	}

	loadCurrSymbol();
</script>