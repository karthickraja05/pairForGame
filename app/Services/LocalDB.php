<?php 

namespace App\Services;


class LocalDB{

	public $db_folder = '../database/local_db/';
	

	public function addData($data){
		file_put_contents($this->connection_json, json_encode($data));
		$this->updateDataValue();
	}
	
}