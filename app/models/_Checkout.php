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
				`o_status` = 0 
				AND `o_buyer` = ' . $_SESSION['u']->id
		);
		return $this->db->single();

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

		$this->db->bind(':id', $id);

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
}

?>