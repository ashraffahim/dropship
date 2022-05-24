<?php

namespace models;

use libraries\Database;

class _User {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function exist($e) {
		$this->db->query('SELECT `id` FROM `buyer` WHERE `b_email` = :e');
		$this->db->bind(':e', $e, $this->db->PARAM_STR);
		return $this->db->single();
	}

	public function setTmp($d) {
		if (isset($this->exist($d['email'])->id)) {
			return [
				'status' => 0,
				'cardTag' => [
					'type' => 'warning',
					'icon' => 'exclamation-triangle',
					'body' => '<b>Email already registered!</b> Try <a href="/login">Log in</a>'
				]
			];
		}

		if (isset($_SESSION['tmp_em'])) {
			return [
				'status' => 0,
				'cardTag' => [
					'type' => 'warning',
					'icon' => 'exclamation-triangle',
					'body' => '<b>Email is being processed</b>'
				]
			];
		}

		$_SESSION['tmp_fn'] = $d['first_name'];
		$_SESSION['tmp_ln'] = $d['last_name'];
		$_SESSION['tmp_em'] = $d['email'];
		$_SESSION['tmp_pw'] = $d['password'];
		$_SESSION['tmp_c'] = $d['country'];

		return [
			'status' => 1
		];
	}

	public function createVCode() {
		$_SESSION['vcode'] = rand(100000, 999999);
		$_SESSION['atmp'] = 0;
	}

	public function emailVCode() {
		$email = new \libraries\Email();
		$email->send($_SESSION['tmp_em'], 'Confrim Signup', "<h3>{$_SESSION['vcode']}</h3>", '');
	}

	public function verifyEmail($v) {
		
		$_SESSION['atmp']++;

		if ($v == $_SESSION['vcode']) {
		
			return $this->createUser();
		
		} else {

			// Check attempt

			if ($_SESSION['atmp'] > 4) {

				// Attempts exceeded

				$this->createVCode();
				$this->emailVCode();

				return [
					'status' => 0,
					'cardTag' => [
						'type' => 'danger',
						'icon' => 'exclamation-triangle',
						'body' => '<b>Too many attempts!</b> New code sent to your email.'
					]
				];
			}

			// Failed attempt
			return [
				'status' => 0,
				'cardTag' => [
					'type' => 'danger',
					'icon' => 'exclamation-triangle',
					'body' => '<b>Wrong verification code!</b> ' . (3 - $_SESSION['atmp']) . ' attempts left'
				]
			];
		}
	}

	public function createUser() {
		$this->db->query('
		INSERT INTO 
			`buyer` 
			(
				`b_first_name`, 
				`b_last_name`, 
				`b_email`,
				`b_password`,
				`b_country`,
				`b_timestamp`,
				`b_latimestamp`
			) 
		VALUES 
			(
				:fn,
				:ln,
				:em,
				:pw,
				:c,
				' . time() . ',
				' . time() . '
			)
		');

		$this->db->bind(':fn', $_SESSION['tmp_fn'], $this->db->PARAM_STR);
		$this->db->bind(':ln', $_SESSION['tmp_ln'], $this->db->PARAM_STR);
		$this->db->bind(':em', $_SESSION['tmp_em'], $this->db->PARAM_STR);
		$this->db->bind(':pw', md5($_SESSION['tmp_pw']), $this->db->PARAM_STR);
		$this->db->bind(':c', $_SESSION['tmp_c'], $this->db->PARAM_STR);

		$this->db->execute();

		return [
			'status' => 1
		];
	}

	public function login($e, $p) {
		$this->db->query('
		SELECT 
			`id`, 
			`b_first_name` AS `n`, 
			`b_email` AS `e`, 
			`b_country` AS `c` 
		FROM 
			`buyer` 
		WHERE 
			`b_email` = :e 
			AND `b_password` = :p
		');

		$this->db->bind(':e', $e, $this->db->PARAM_STR);
		$this->db->bind(':p', md5($p), $this->db->PARAM_STR);

		$d = $this->db->single();

		return [
			'status' => isset($d->id) ? 1 : 0,
			'data' => $d
		];
	}
}

?>