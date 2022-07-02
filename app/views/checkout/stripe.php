<script src="https://js.stripe.com/v3/"></script>
<script src="/assets/js/payment/stripe.js" defer></script>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-6 col-md-8 col-sm-10">
			<div class="card shadow-sm">
				<div class="card-body">
					<form method="post" id="payment-form">
						<div class="row mb-3">
							<div class="col-12">
								<div id="payment-message" class="d-none card-tag card-tag-danger"></div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-12">
								<div id="payment-element">
									<!--Stripe.js injects the Payment Element-->
								</div>
							</div>
						</div>
						<div class="row justify-content-start flex-row-reverse">
							<div class="col-lg-4 col-md-6">
								<button id="submit" class="btn btn-dark btn-block">
									<div class="loading-spinner d-none" id="spinner"></div>
									<span id="button-text">Pay now</span>
								</button>
							</div>
							<div class="col-lg-4 col-md-6">
								<a href="/cart" class="btn btn-block">
									<span>Cancel</span>
								</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>