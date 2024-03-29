<?php

namespace models;

use libraries\Database;

class _Checkout {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function availMethod() {
		$this->db->query('
			SELECT 
				`id`, 
				`name`, 
				`code` 
			FROM 
				`sys_payment_method`
		');

		return $this->db->result();
	}

	public function pendingOrder() {
		
		$this->db->query('
			SELECT 
				`id` 
			FROM 
				`order` 
			WHERE 
				`id` NOT IN (
					SELECT 
						`p_order` 
					FROM 
						`payment`
				)
				AND `o_buyer` = ' . $_SESSION['u']->id
		);
		return $this->db->single();

	}

	public function validatePayableID($id) {
		$this->db->query('
			SELECT 
				`id` 
			FROM 
				`order` 
			WHERE 
				`id` = :id AND 
				`id` NOT IN (
					SELECT 
						`p_order` 
					FROM 
						`payment`
				)
		');

		$this->db->bind(':id', $id, $this->db->PARAM_INT);

		return isset($this->db->single()->id);
	}

	public function orderCurrency($id) {
		
		$this->db->query('
			SELECT 
				`o_currency` 
			FROM 
				`order` 
			WHERE 
				`id` = :id
		');
		$this->db->bind(':id', $id, $this->db->PARAM_INT);

		return $this->db->single()->o_currency;

	}

	public function serviceCharge() {
		$this->db->query('SELECT `amount` FROM `sys_charge`');
		return $this->db->single()->amount;
	}

	public function orderPayable($id) {

		// Charges, Shipping cost and Discount
		$this->db->query('
			SELECT 
				(`o_service_charge` + `o_ship_cost` - `o_discount`) AS `ha` 
			FROM 
				`order` 
			WHERE 
				`id` = :id 
				AND `o_status` = 0 
				AND `o_buyer` = ' . $_SESSION['u']->id . '
		');

		$this->db->bind(':id', $id, $this->db->PARAM_INT);

		$ha = $this->db->single()->ha;

		// Ordered items total amount
		$this->db->query('
			SELECT 
				SUM(`oi_qty` * `oi_price`) AS `ba` 
			FROM 
				`order_item` 
			WHERE 
				`oi_invoice` = :id 
			GROUP BY 
				`oi_invoice`
		');

		$this->db->bind(':id', $id);

		$ba = $this->db->single()->ba;

		return $ha + $ba;
	}

	public function order($d) {

		$ids = implode(',', $d['item']);

		if (!preg_match('/^[0-9,]+$/', $ids)) {
			exit;
		}

		// 
		// Limit items to of one currency
		// 

		if (isset($d['c'])) {
			
			// When one currency of item IS chosen
			// Verify currency

			$this->db->query('
				SELECT 
					`s_currency` 
				FROM 
					`seller` 
				WHERE 
					`id` IN (
						SELECT 
							`p_sellerstamp` 
						FROM 
							`product` 
						WHERE 
							`id` IN (' . $ids . ')
						) 
					AND `s_currency` = :c
			');

			$this->db->bind(':c', $d['c'], $this->db->PARAM_STR);

			$c = $this->db->single()->s_currency;

		} else {

			// When one currency of item is NOT chosen
			// Select one currency from cart item

			$this->db->query('
				SELECT DISTINCT 
					`s_currency` 
				FROM 
					`seller` 
				WHERE 
					`id` IN (
						SELECT 
							`p_sellerstamp` 
						FROM 
							`product` 
						WHERE 
							`id` IN (' . $ids . ')
						) 
					LIMIT 1
			');

			$c = $this->db->single()->s_currency;

		}

		$this->db->query('
			SELECT 
				`id` 
			FROM 
				`product` 
			WHERE 
				`id` IN (' . $ids . ') 
				AND `p_sellerstamp` IN (
					SELECT 
						`id` 
					FROM 
						`seller` 
					WHERE 
						`s_currency` = "' . $c . '"
				)
		');


		// Isolating ids
		$isidsarr = [];
		$isids = $this->db->result();
		
		foreach ($isids as $p) {
			$isidsarr[] = $p->id;
		}

		// Isolated ids with one currency

		$ids = implode(',', $isidsarr);


		// 
		// Preparing statement for inserting order items
		// Only Product: id, qty, price given in placeholder '?'
		// Order id foreign key is later bound after `Order` insertion 
		// 

		$this->db->query('SELECT `id`, `p_price` FROM `product` WHERE `id` IN (' . $ids . ')');
		$o = $this->db->result();

		$vp = '';
		$vs = [];

		// Calc variables
		$ta = 0;

		foreach ($o as $i => $p) {
			$vp .= ($i > 0 ? ',' : '') . '(
				i,
				?,
				?,
				?
			)';

			$vs[] = $p->id;
			$vs[] = $d['qty_' . $p->id];
			$vs[] = $p->p_price;

			$ta += ((int)$d['qty_' . $p->id] * $p->p_price);
		}

		// Service cahrge calc
		$sf = $ta * $this->serviceCharge();

		// 
		// End currency control
		// 

		// -------------_+=---------------
		// -------------_+=---------------
		// -------------_+=---------------

		// 
		// Check pending order
		// 

		$po = $this->pendingOrder();

		// 
		// End check pending order
		// 

		if (isset($po->id)) {

			// Previous pending order
			// Create order
			$this->db->query('
				UPDATE 
					`order`
				SET 
					`o_currency` = "' . $c . '",
					`o_discount` = :d, 
					`o_service_charge` = :sf,
					`o_ship_cost` = :sc,
					`o_ship_address_1` = :sd1,
					`o_ship_address_2` = :sd2,
					`o_ship_country` = :sctr,
					`o_ship_city` = :scty,
					`o_ship_po_box` = :spb,
					`o_ship_mobile` = :sm,
					`o_ship_email` = :se,
					`o_status` = :s,
					`o_latimestamp` = ' . time() . ' 
				WHERE 
					`id` = ' . $po->id . ' 
					AND `o_buyer` = ' . $_SESSION['u']->id . '
			');
			
			$this->db->bind(':d', 0, $this->db->PARAM_STR);
			$this->db->bind(':sf', $sf, $this->db->PARAM_STR);
			$this->db->bind(':sc', 0, $this->db->PARAM_STR);
			$this->db->bind(':sd1', $d['address'], $this->db->PARAM_STR);
			$this->db->bind(':sd2', $d['address_2'], $this->db->PARAM_STR);
			$this->db->bind(':sctr', $d['country'], $this->db->PARAM_STR);
			$this->db->bind(':scty', $d['city'], $this->db->PARAM_STR);
			$this->db->bind(':spb', $d['zip'], $this->db->PARAM_STR);
			$this->db->bind(':sm', $d['phone'], $this->db->PARAM_STR);
			$this->db->bind(':se', $d['email'], $this->db->PARAM_STR);
			$this->db->bind(':s', 0, $this->db->PARAM_INT);

			if (!$this->db->execute()) {
				return [
					'status' => 0,
					'id' => $po->id
				];
			}

			// 
			// Remove pending order items
			// 

			$this->db->query('
				DELETE FROM 
					`order_item` 
				WHERE 
					`oi_invoice` = ' . $po->id
			);

			if (!$this->db->execute()) {
				return [
					'status' => 0,
					'id' => $po->id
				];
			}

			$inv = $po->id;

			// 
			// End of altered order
			// 

		} else {

			// No previous pending order
			// Create order
	
			$this->db->query('
				INSERT INTO 
					`order` (
						`o_currency`, 
						`o_buyer`, 
						`o_discount`, 
						`o_service_charge`,
						`o_ship_cost`,
						`o_ship_address_1`,
						`o_ship_address_2`,
						`o_ship_country`,
						`o_ship_city`,
						`o_ship_po_box`,
						`o_ship_mobile`,
						`o_ship_email`,
						`o_status`,
						`o_timestamp`,
						`o_latimestamp`
					) VALUES (
						"' . $c . '",
						' . $_SESSION['u']->id . ',
						:d,
						:sf,
						:sc,
						:sd1,
						:sd2,
						:sctr,
						:scty,
						:spb,
						:sm,
						:se,
						:s,
						' . time() . ',
						' . time() . '
					)
			');
			
			$this->db->bind(':d', 0, $this->db->PARAM_STR);
			$this->db->bind(':sf', $sf, $this->db->PARAM_STR);
			$this->db->bind(':sc', 0, $this->db->PARAM_STR);
			$this->db->bind(':sd1', $d['address'], $this->db->PARAM_STR);
			$this->db->bind(':sd2', $d['address_2'], $this->db->PARAM_STR);
			$this->db->bind(':sctr', $d['country'], $this->db->PARAM_STR);
			$this->db->bind(':scty', $d['city'], $this->db->PARAM_STR);
			$this->db->bind(':spb', $d['zip'], $this->db->PARAM_STR);
			$this->db->bind(':sm', $d['phone'], $this->db->PARAM_STR);
			$this->db->bind(':se', $d['email'], $this->db->PARAM_STR);
			$this->db->bind(':s', 0, $this->db->PARAM_INT);
	
			if (!$this->db->execute()) {
				return [
					'status' => 0,
					'id' => null
				];
			}
	
			$inv = $this->db->lastInsertId();

			// 
			// End of new order
			// 
		}


		// 
		// Add order items
		// Values and plaholders prepared before `Order` insertion 
		// 

		// Replace with order id in positional placeholder values
		$vp = str_replace('i', $inv, $vp);

		$this->db->query('
			INSERT INTO 
				`order_item` (
					`oi_invoice`,
					`oi_product`,
					`oi_qty`,
					`oi_price`
				) 
			VALUES ' . $vp . '
		');

		if ($this->db->execute($vs)) {
			return [
				'status' => 1,
				'id' => $inv
			];
		} else {
			return [
				'status' => 0,
				'id' => $inv
			];
		}
	}

	public function success($id, $is) {
		if ($id == '' || $is == '') {
			return [
				'status' => 0
			];
		}

		$this->db->query('
			SELECT 
				`id`, 
				`o_service_charge`, 
				`o_ship_cost`, 
				`o_discount`, 
				(SELECT `currency_symbol` FROM `sys_country` WHERE `currency` = `o`.`o_currency`) `cur`, 
				(SELECT SUM(`oi_price` * `oi_qty`) FROM `order_item` WHERE `oi_invoice` = `o`.`id`) `stotal` 
			FROM 
				`order` `o` 
			WHERE 
				`id` = :id AND 
				`id` NOT IN (
					SELECT 
						`p_order` 
					FROM 
						`payment`
				) AND 
				`o_buyer` = ' . $_SESSION['u']->id
		);

		$this->db->bind(':id', $id, $this->db->PARAM_INT);

		$o = $this->db->single();

		if ($o) {
			$id = $o->id;
			
			// For invoice email
			$dt = date('M d, Y');
			$cu = $o->cur;
			$st = $o->stotal;
			$sch = $o->o_service_charge;
			$sc = $o->o_ship_cost;
			$dnt = $o->o_discount;
			$tt = $st + $sch + $sc - $dnt;
		} else {
			return [
				'status' => 0
			];
		}

		$this->db->query('
			INSERT INTO
				`payment` (
					`p_order`, 
					`p_method`, 
					`p_secret`, 
					`p_status`,
					`p_timestamp`,
					`p_latimestamp`
					) 
			VALUES (
				:o,
				1,
				:s,
				0,
				:t,
				:lt
			)
		');

		$this->db->bind(':o', $id, $this->db->PARAM_INT);
		$this->db->bind(':s', $is, $this->db->PARAM_STR);
		$this->db->bind(':t', time(), $this->db->PARAM_INT);
		$this->db->bind(':lt', time(), $this->db->PARAM_INT);

		$this->db->execute();

		$receipt = <<<EOF
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="font-family:arial, 'helvetica neue', helvetica, sans-serif"><head> 
		<meta charset="UTF-8"> 
		<meta content="width=device-width, initial-scale=1" name="viewport"> 
		<meta name="x-apple-disable-message-reformatting"> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta content="telephone=no" name="format-detection"> 
		<title>New Template</title><!--[if (mso 16)]>
		  <style type="text/css">
		  a {text-decoration: none;}
		  </style>
		  <![endif]--><!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--><!--[if gte mso 9]>
	  <xml>
		  <o:OfficeDocumentSettings>
		  <o:AllowPNG></o:AllowPNG>
		  <o:PixelsPerInch>96</o:PixelsPerInch>
		  </o:OfficeDocumentSettings>
	  </xml>
	  <![endif]--> 
		<style type="text/css">
	  #outlook a {
		  padding:0;
	  }
	  .es-button {
		  mso-style-priority:100!important;
		  text-decoration:none!important;
	  }
	  a[x-apple-data-detectors] {
		  color:inherit!important;
		  text-decoration:none!important;
		  font-size:inherit!important;
		  font-family:inherit!important;
		  font-weight:inherit!important;
		  line-height:inherit!important;
	  }
	  .es-desk-hidden {
		  display:none;
		  float:left;
		  overflow:hidden;
		  width:0;
		  max-height:0;
		  line-height:0;
		  mso-hide:all;
	  }
	  [data-ogsb] .es-button {
		  border-width:0!important;
		  padding:10px 30px 10px 30px!important;
	  }
	  @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120%!important } h1 { font-size:36px!important; text-align:left } h2 { font-size:26px!important; text-align:left } h3 { font-size:20px!important; text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:36px!important; text-align:left } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px!important; text-align:left } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important; text-align:left } .es-menu td a { font-size:12px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:14px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:14px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button, button.es-button { font-size:20px!important; display:inline-block!important } .es-adaptive table, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0!important } .es-m-p0r { padding-right:0!important } .es-m-p0l { padding-left:0!important } .es-m-p0t { padding-top:0!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .es-m-p5 { padding:5px!important } .es-m-p5t { padding-top:5px!important } .es-m-p5b { padding-bottom:5px!important } .es-m-p5r { padding-right:5px!important } .es-m-p5l { padding-left:5px!important } .es-m-p10 { padding:10px!important } .es-m-p10t { padding-top:10px!important } .es-m-p10b { padding-bottom:10px!important } .es-m-p10r { padding-right:10px!important } .es-m-p10l { padding-left:10px!important } .es-m-p15 { padding:15px!important } .es-m-p15t { padding-top:15px!important } .es-m-p15b { padding-bottom:15px!important } .es-m-p15r { padding-right:15px!important } .es-m-p15l { padding-left:15px!important } .es-m-p20 { padding:20px!important } .es-m-p20t { padding-top:20px!important } .es-m-p20r { padding-right:20px!important } .es-m-p20l { padding-left:20px!important } .es-m-p25 { padding:25px!important } .es-m-p25t { padding-top:25px!important } .es-m-p25b { padding-bottom:25px!important } .es-m-p25r { padding-right:25px!important } .es-m-p25l { padding-left:25px!important } .es-m-p30 { padding:30px!important } .es-m-p30t { padding-top:30px!important } .es-m-p30b { padding-bottom:30px!important } .es-m-p30r { padding-right:30px!important } .es-m-p30l { padding-left:30px!important } .es-m-p35 { padding:35px!important } .es-m-p35t { padding-top:35px!important } .es-m-p35b { padding-bottom:35px!important } .es-m-p35r { padding-right:35px!important } .es-m-p35l { padding-left:35px!important } .es-m-p40 { padding:40px!important } .es-m-p40t { padding-top:40px!important } .es-m-p40b { padding-bottom:40px!important } .es-m-p40r { padding-right:40px!important } .es-m-p40l { padding-left:40px!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; max-height:inherit!important } }
	  </style> 
	   </head> 
	   <body style="width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0"> 
		<div class="es-wrapper-color" style="background-color:#FAFAFA"><!--[if gte mso 9]>
				  <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
					  <v:fill type="tile" color="#fafafa"></v:fill>
				  </v:background>
			  <![endif]--> 
		 <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#FAFAFA"> 
		   <tbody><tr> 
			<td valign="top" style="padding:0;Margin:0"> 
			 <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
			   <tbody><tr> 
				<td align="center" style="padding:0;Margin:0"> 
				 <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px"> 
				   <tbody><tr> 
					<td align="left" style="padding:0;Margin:0;padding-top:15px;padding-left:20px;padding-right:20px"> 
					 <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
					   <tbody><tr> 
						<td align="center" valign="top" style="padding:0;Margin:0;width:560px"> 
						 <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
						   <tbody><tr> 
							<td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;font-size:0px"><img src="https://grap.store/assets/img/grap-logo.png" alt="" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="100" height="98"></td> 
						   </tr> 
						   <tr> 
							<td align="center" class="es-m-txt-c" style="padding:0;Margin:0;padding-bottom:10px"><h1 style="Margin:0;line-height:46px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:46px;font-style:normal;font-weight:bold;color:#333333">Order confirmation</h1></td> 
						   </tr> 
						 </tbody></table></td> 
					   </tr> 
					 </tbody></table></td> 
				   </tr> 
				 </tbody></table></td> 
			   </tr> 
			 </tbody></table> 
			 <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
			   <tbody><tr> 
				<td align="center" style="padding:0;Margin:0"> 
				 <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px"> 
				   <tbody><tr> 
					<td align="left" style="padding:20px;Margin:0"> 
					 <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
					   <tbody><tr> 
						<td align="center" valign="top" style="padding:0;Margin:0;width:560px"> 
						 <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
						   <tbody><tr> 
							<td align="center" class="es-m-txt-c" style="padding:0;Margin:0"><h2 style="Margin:0;line-height:31px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:26px;font-style:normal;font-weight:bold;color:#333333">Order&nbsp;<a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#5C68E2;font-size:26px">#$id</a></h2></td> 
						   </tr> 
						   <tr> 
							<td align="center" class="es-m-p0r es-m-p0l" style="Margin:0;padding-top:5px;padding-bottom:5px;padding-left:40px;padding-right:40px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">$dt</p></td> 
						   </tr> 
						   <tr> 
							<td align="center" class="es-m-p0r es-m-p0l" style="Margin:0;padding-top:5px;padding-bottom:15px;padding-left:40px;padding-right:40px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">This email is to confirm&nbsp;your order. We will send you another email as soon as it ships.</p></td> 
						   </tr> 
						 </tbody></table></td> 
					   </tr> 
					 </tbody></table></td> 
				   </tr> 
					
					
				   <tr> 
					<td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px"> 
					 <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
					   <tbody><tr> 
						<td class="es-m-p0r" align="center" style="padding:0;Margin:0;width:560px"> 
						 <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:2px solid #efefef;border-bottom:2px solid #efefef" role="presentation"> 
						   <tbody><tr> 
							<td align="right" class="es-m-txt-r" style="padding:0;Margin:0;padding-top:10px;padding-bottom:20px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Subtotal:&nbsp;<strong>$cu$st</strong><br>Shipping:&nbsp;<strong>$cu$sc</strong><br>Service:&nbsp;<strong>$cu$sch</strong><br>Discount:&nbsp;<strong>$cu$dnt</strong><br>Total:&nbsp;<strong>$cu$tt</strong></p></td> 
						   </tr> 
						 </tbody></table></td> 
					   </tr> 
					 </tbody></table></td> 
				   </tr> 
				   <tr> 
					<td align="left" style="Margin:0;padding-bottom:10px;padding-top:15px;padding-left:20px;padding-right:20px"> 
					 <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
					   <tbody><tr> 
						<td align="left" style="padding:0;Margin:0;width:560px"> 
						 <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
						   <tbody><tr> 
							<td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Got a question?&nbsp;Email us at&nbsp;<a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#5C68E2;font-size:14px">support@grap.store</a>&nbsp;or give us a call at&nbsp;<a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#5C68E2;font-size:14px">+971 56 282 9271</a>.</p></td> 
						   </tr> 
						 </tbody></table></td> 
					   </tr> 
					 </tbody></table></td> 
				   </tr> 
				 </tbody></table></td> 
			   </tr> 
			 </tbody></table> 
			 <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top"> 
			   <tbody><tr> 
				<td align="center" style="padding:0;Margin:0"> 
				 <table class="es-footer-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:640px"> 
				   <tbody><tr> 
					<td align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px"> 
					 <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
					   <tbody><tr> 
						<td align="left" style="padding:0;Margin:0;width:600px"> 
						 <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
						   <tbody><tr> 
							<td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px;font-size:0"> 
							 <table cellpadding="0" cellspacing="0" class="es-table-not-adapt es-social" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
							   <tbody><tr> 
								<td align="center" valign="top" style="padding:0;Margin:0"><a target="_blank" href="https://www.instagram.com/storegrap" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#333333;font-size:12px"><img title="Instagram" src="https://jpcukn.stripocdn.email/content/assets/img/social-icons/logo-colored/instagram-logo-colored.png" alt="Inst" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td> 
							   </tr> 
							 </tbody></table></td> 
						   </tr> 
						   <tr> 
							<td align="center" style="padding:0;Margin:0;padding-bottom:35px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#333333;font-size:12px">Grap&nbsp;© 2022, All Rights Reserved.</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#333333;font-size:12px">#101, 28 Arabian Gulf Street, Sharjah, United Arab Emirates</p></td> 
						   </tr> 
						   <tr> 
							<td style="padding:0;Margin:0"> 
							 <table cellpadding="0" cellspacing="0" width="100%" class="es-menu" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
							   <tbody><tr class="links"> 
								<td align="center" valign="top" width="33.33%" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;border:0"><a target="_blank" href="https://grap.store" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;display:block;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#999999;font-size:12px">Visit Us </a></td> 
								<td align="center" valign="top" width="33.33%" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;border:0;border-left:1px solid #cccccc"><a target="_blank" href="https://grap.store/privacy-policy" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;display:block;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#999999;font-size:12px">Privacy Policy</a></td> 
								<td align="center" valign="top" width="33.33%" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;border:0;border-left:1px solid #cccccc"><a target="_blank" href="https://grap.store/terms-of-use" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;display:block;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#999999;font-size:12px">Terms of Use</a></td> 
							   </tr> 
							 </tbody></table></td> 
						   </tr> 
						 </tbody></table></td> 
					   </tr> 
					 </tbody></table></td> 
				   </tr> 
				 </tbody></table></td> 
			   </tr> 
			 </tbody></table> 
			 <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
			   <tbody><tr> 
				<td class="es-info-area" align="center" style="padding:0;Margin:0"> 
				 <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" bgcolor="#FFFFFF"> 
				   <tbody><tr> 
					<td align="left" style="padding:20px;Margin:0"> 
					 <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
					   <tbody><tr> 
						<td align="center" valign="top" style="padding:0;Margin:0;width:560px"> 
						 <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
						   <tbody><tr> 
							<td align="center" class="es-infoblock" style="padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:14px;color:#CCCCCC;font-size:12px"><a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px"></a>No longer want to receive these emails?&nbsp;<a href="" target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px">Unsubscribe</a>.<a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px"></a></p></td> 
						   </tr> 
						 </tbody></table></td> 
					   </tr> 
					 </tbody></table></td> 
				   </tr> 
				 </tbody></table></td> 
			   </tr> 
			 </tbody></table></td> 
		   </tr> 
		 </tbody></table> 
		</div>  
	   
	  </body></html>
EOF;

		$email = new \libraries\Email();
		$email->send($_SESSION['u']->e, 'Order Successfully Places', $receipt, '', false);

		return [
			'status' => 1
		];
	}
}

?>