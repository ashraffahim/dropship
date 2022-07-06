<?php

namespace models;

use libraries\Database;

class _Webhook {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function confirmPayment($cs) {
		$this->db->query('
			SELECT 
				`id` 
			FROM 
				`payment` 
			WHERE 
				`p_secret` = :cs
		');

		$this->db->bind(':cs', $cs);
		$p = $this->db->single();

		// Payment intent not captured
		if (!$p) {

			// Payment intent captured
			$this->db->query('
				INSERT INTO 
					`payment` (
						`p_secret`, 
						`p_status`, 
						`p_timestamp`, 
						`p_latimestamp`
					) 
				VALUES 
					(
						:cs, 
						2, 
						' . time() . ', 
						' . time() . '
					)
			');
			$this->db->bind(':cs', $cs);
			
			$this->db->execute();
			return 'Payment intent not captured';
		}

		// Payment intent captured
		$this->db->query('
			UPDATE 
				`payment` 
			SET 
				`p_status` = 1 
				`p_latimestamp` = ' . time() . ' 
			WHERE 
				`id` = ' . $p->id . '
		');
		
		$this->db->execute();
		return $p->id;
	}

}

?>