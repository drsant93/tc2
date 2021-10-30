<?php

class model {

	protected $db;
	protected $dbCCD;
	public function __construct() {
		global $db;

		$this->db = $db;

	}
}