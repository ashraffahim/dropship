<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-6 col-md-8 col-sm-10">
			<div class="card shadow-sm">
				<div class="card-body">
					<?php
					if ($data['data']['status'] == 1) {
					?>
					
					<div class="card-tag card-tag-success">
						<div>
							<b>Payment successful</b> Your order will be delivered soon.
						</div>
					</div>

					<?php
					} else {
					?>
					
					<div class="card-tag card-tag-danger">
						<div>
							<b>Payment unsuccessful</b> We are looking into it.
						</div>
					</div>
					
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>