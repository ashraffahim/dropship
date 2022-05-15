<div class="container-fluid">
	<form method="post">
		<div class="row">
			<div class="col-md-7 offset-md-1">
				<div class="card shadow-sm mb-3">
					<div class="card-body">

						<!-- Cart data -->
						<div class="row mb-3">
							<div class="col-12">
								<table class="table table-lg">
									<thead>
										<tr>
											<th></th>
											<th>Item</th>
											<th>Qty</th>
											<th>Price</th>
											<th></th>
										</tr>
									</thead>
									<tbody class="cart-data"></tbody>
								</table>
							</div>
						</div>

					</div>
				</div>
			</div>

			<!-- Buttons -->
			<div class="col-md-3">
				<div class="card shadow-sm">
					<div class="card-body">
						<div class="row mb-3">
							<div class="col-12">
								<h3>Totals</h3>
							</div>
							<div class="col-12 text-muted">
								<div class="d-flex justify-content-between">
									<div>Qty</div>
									<div class="total-qty">0.00</div>
								</div>
								<div class="d-flex justify-content-between">
									<div>Amount</div>
									<div class="total-amount">0.00</div>
								</div>
								<div class="d-flex justify-content-between">
									<div>Discount</div>
									<div class="total-discount">0.00</div>
								</div>
								<div class="d-flex justify-content-between">
									<div>VAT</div>
									<div class="total-vat">0.00</div>
								</div>
								<div class="d-flex justify-content-between">
									<b>Payable</b>
									<b class="total-invoice-amount fct">0.00</b>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-12">
								<div class="text-muted">
									By proceeding to checkout you are agreeing to our <a href="#" class="fct">Service Policy</a> & <a href="#" class="fct">Payment & Refund Policy</a>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<button type="submit" class="btn btn-theme btn-block">CHECKOUT</button>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>
<script>loadCartData();</script>