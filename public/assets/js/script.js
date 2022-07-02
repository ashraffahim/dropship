function allowAddToCart() {
	var n, p, q, id;
	n = $('.product-details ._pn').text().replaceAll('\n', '').replaceAll('\t', '');
	p = $('.product-details ._pp').text().replaceAll('\n', '').replaceAll('\t', '');
	q = 1;

	data = {
		n: n,
		p: n,
		q: q
	};

	$('.add-to-cart').on('click', function() {
		id = $(this).data('id');
		addToCart(id, JSON.stringify(data));
	});
}

function cartItemCount() {
	var n = 0;
	for (let i = 0; i < localStorage.length; i++) {
		if (localStorage.key(i).match(/^ci[0-9]+$/)) {
			n++;
		}
	}
	return n;
}


function addToCart(id, data) {
	if (localStorage.getItem('ci' + id) == null) {
		localStorage.setItem('ci' + id, data);
	}
}

function setQtyToCart(id, q) {
	if (localStorage.getItem('ci' + id) != null) {
		var d = JSON.parse(localStorage.getItem('ci' + id));
		d.q = q;

		localStorage.setItem('ci' + id, JSON.stringify(d));
	}
}

function removeFromCart(id) {
	localStorage.removeItem('ci' + id);
}

function getCartIds() {
	var d = '', m;
	for (let i = 0; i < localStorage.length; i++) {
		m = localStorage.key(i).match(/^ci([0-9])+$/);
		if (m) {
			d += d != '' ? ',' : '';
			d += m[1];
		}
	}
	return d;
}

function calculateCartTotal(opt) {
	var q = 0, a = 0, d = 0, c = 0, sc = '';
	if ($('.sccb:checked').length) {
		sc = '.sc' + $('.sccb:checked').val();
	}
	$(`.cart-data tr${sc}:not(.sc)`).each(function() {
		q += Number($(this).find('.qty').val());
		a += Number($(this).find('.qty').val()) * Number($(this).find('.price').text());
	});

	c = a * opt.serviceCharge;

	$('.total-qty').text(q);
	$('.total-amount').text(a.toFixed(2));
	$('.total-discount').text(d.toFixed(2));
	$('.total-charge').text(c.toFixed(2));
	$('.total-invoice-amount').text((a - d + c).toFixed(2));
}

function cartDataEL(opt) {
	// Cart data event listeners
	$('.cart-data').on('change', '.qty', function() {
		setQtyToCart($(this).attr('name').match(/^qty_([0-9]+)$/)[1], $(this).val());
		calculateCartTotal(opt);
	});

	$('.cart-data').on('change', '.sccb', function() {
		calculateCartTotal(opt);
	});
	
	$('.cart-data').on('click', '.rmic', function() {
		removeFromCart($(this).data('id'));
		$(this).parents('tr').remove();
		calculateCartTotal(opt);
	});
}

function loadCartData(opt) {
	$('.cart-data').empty();
	$.ajax({
		type: 'POST',
		url: '/cart/data',
		data: 'ids=' + getCartIds(),
		success: function(data) {
			var lsjd, jd = JSON.parse(data), t = 0, ps = [], ks;

			for (var i = 0; i < jd.length; i++) {
				lsjd = JSON.parse(localStorage.getItem('ci' + jd[i].id));
				t += Number(jd[i].p_price);
				if (typeof ps[jd[i].s_currency] == 'undefined') {
					ps[jd[i].s_currency] = `<tr class="sc"><td colspan="5"><label><input type="radio" name="c" value="${jd[i].s_currency}" class="sccb"> Buy all in ${jd[i].s_currency}</label></td></tr>`;
				}
				ps[jd[i].s_currency] += `<tr class="sc${jd[i].s_currency}"><td>${i+1}<input type="hidden" name="item[]" value="${jd[i].id}"></td><td>${jd[i].p_name}</td><td><input type="number" name="qty_${jd[i].id}" value="${lsjd.q}" min="0" class="border-0 qty" required></td><td>${jd[i].s_currency}<span class="price">${jd[i].p_price}</span></td><td class="text-right"><a class="btn rmic hta" data-id="${jd[i].id}"><i class="fal fa-trash text-danger"></i></a></td></tr>`;
			}
			ks = Object.keys(ps);
			for (let k of ks) {
				$('.cart-data').append(ps[k]);
			}
			if (ks.length > 1) {
				$('.cart-alert').append('<div class="card-tag card-tag-info">Items of ONE currency can be bought at a time</div>');
			} else {
				$('tr.sc').hide();
			}
			calculateCartTotal(opt);
		}
	});
}

function crsl() {
	
	var c, f, l;
	
	f = $('.crsl .crsli:first');
	l = $('.crsl .crsli:last');
	f.addClass('active');

	$('.crsl').on('click', '.crslp, .crsln', function() {
		c = $(this).parents('.crsl').find('.crsli.active');
		if ($(this).is('.crslp')) {
			if (c.closest('.crsli').prev().length) {
				c.removeClass('active').closest('.crsli').prev().addClass('active');
			} else {
				c.removeClass('active')
				l.addClass('active');
			}
		} else {
			if (c.closest('.crsli').next().length) {
				c.removeClass('active').closest('.crsli').next().addClass('active');
			} else {
				c.removeClass('active')
				f.addClass('active');
			}
		}
	});
}

function allowOrder() {
	
	var fd;

	$('.checkout-form').on('submit', function(e) {
		
		e.preventDefault();
		$('.checkout').html('<i class="loading-spinner"></i>');
		fd = $(this).serialize();

		$.ajax({
			type: 'POST',
			url: '/checkout/order',
			data: fd,
			success: function(data) {

				data = JSON.parse(data);
				
				if (data.status == '1') {
					
					$('.checkout').html('CHECKOUT');
					$('.payment-method a').each(function() {
						$(this).attr('href', $(this).attr('href').replace('{id}', data.id));
					});
					$('.payment-method, .shipping-address-container').collapse('toggle');
				} else {
					$('.checkout').toggleClass('btn-theme btn-danger').prop('disabled', true).html('CHECKOUT FAILED');
				}

			}
		});
	});

	$('.proceed-to-checkout').click(function() {
		$('.shipping-address-container').collapse('show');
		$('.checkout-btn-container').collapse('hide');
	});
	$('.cancel-checkout').click(function() {
		$('.payment-method').collapse('hide');
		$('.checkout-btn-container').collapse('show');
	});
}