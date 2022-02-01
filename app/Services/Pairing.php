<?php 

namespace App\Services;


class Pairing extends LocalDB{

	public $connection_json_name = 'pairing.json';

	public $connection_json;

	public function __construct()
	{	
		$this->connection_json = $this->db_folder.$this->connection_json_name;
		$this->data = $this->readFile();
	}

	

	



}