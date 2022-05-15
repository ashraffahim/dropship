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

function calculateCartTotal() {
	var q = 0, a = 0, d = 0, v = 0;
	$('.cart-data tr').each(function() {
		q += Number($(this).find('.qty').val());
		a += Number($(this).find('.qty').val()) * Number($(this).find('.price').text());
	});
	$('.total-qty').text(q);
	$('.total-amount').text(a.toFixed(2));
	$('.total-discount').text(d.toFixed(2));
	$('.total-vat').text(v.toFixed(2));
	$('.total-invoice-amount').text((a - d - v).toFixed(2));
}

function loadCartData() {
	$.ajax({
		type: 'POST',
		url: '/cart/data',
		data: 'ids=' + getCartIds(),
		success: function(data) {
			var lsjd, jd = JSON.parse(data), t = 0;

			for (var i = 0; i < jd.length; i++) {
				lsjd = JSON.parse(localStorage.getItem('ci' + jd[i].id));
				$('.cart-data').append(`<tr><td>${i+1}<input type="hidden" name="item[]" value="${jd[i].id}"></td><td>${jd[i].p_name}</td><td><input type="number" name="qty[]" value="${lsjd.q}" min="0" onchange="setQtyToCart(${jd[i].id}, this.value);calculateCartTotal();" class="border-0 qty" required></td><td class="price">${jd[i].p_price}</td><td></td></tr>`);
				t += Number(jd[i].p_price);
			}
			calculateCartTotal();
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