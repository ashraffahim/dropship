<div class="container-fluid">
	<form method="post" class="checkout-form" action="/checkout/order">
		<div class="row">
			<div class="col-md-7 offset-md-1 cart-data-container">
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
			<div class="col-md-3 cart-summary-container">
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
									<div>Service</div>
									<div class="total-charge">0.00</div>
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

						<!-- Payment options -->
						<div class="row payment-method collapse">
							<div class="col-12 mb-1">
								<a href="/checkout/pay/stripe/{id}" class="btn btn-dark btn-block">Credit / Debit Card</a>
							</div>
							<div class="col-12 mb-1">
								<a href="/checkout/pay/bkash/{id}" class="btn bg-bKash btn-block"><img src="/assets/img/bKash-logo.png"> bKash</a>
							</div>
							<div class="col-12">
								<button type="button" class="btn btn-light btn-block cancel-checkout">Cancel</button>
							</div>
						</div>

						<div class="row shipping-address-container collapse">
							<div class="col-12">
								<div class="form-group"><input type="text" name="address" class="form-control" placeholder="Address"></div>
							</div>
							<div class="col-12">
								<div class="form-group"><input type="text" name="address_2" class="form-control" placeholder="Address Line 2"></div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<select name="country" class="custom-select">
										<option disabled selected>Country</option>
										<?php
										foreach ($data['data']['c'] as $c) {
										?>
										<option value="<?php echo $c->code; ?>"><?php echo $c->name; ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group"><input type="text" name="city" class="form-control" placeholder="City"></div>
							</div>
							<div class="col-6">
								<div class="form-group"><input type="text" name="zip" class="form-control" placeholder="ZIP"></div>
							</div>
							<div class="col-12">
								<div class="form-group"><input type="text" name="phone" class="form-control" placeholder="Phone"></div>
							</div>
							<div class="col-12">
								<div class="form-group"><input type="text" name="email" class="form-control" placeholder="Email"></div>
							</div>
							<div class="col-12">
								<button type="submit" class="btn btn-theme btn-block checkout">SUBMIT</button>
							</div>
						</div>

						<!-- Check login -->
						<div class="row checkout-btn-container collapse show">
							<div class="col-12">
								<?php
								if (isset($_SESSION['u'])) {
								?>
								<button type="button" class="btn btn-theme btn-block proceed-to-checkout">CHECKOUT</button>
								<?php
								} else {
								?>
								<a href="/login?redir=/cart" class="btn btn-theme btn-block">CHECKOUT</a>
								<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>
<script>loadCartData({serviceCharge: <?php echo $data['data']['sc']; ?>});allowOrder();</script>