<?php 

namespace App\Services;


class Player extends LocalDB{

	public $connection_json_name = 'players.json';

	public $connection_json;

	public function __construct()
	{	
		$this->connection_json = $this->db_folder.$this->connection_json_name;
		$this->data = $this->readFile();
	}

	



}