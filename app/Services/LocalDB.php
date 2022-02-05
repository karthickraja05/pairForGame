<?php 

namespace App\Services;


class LocalDB{

	public $db_folder = '../database/local_db/';
	
	public function addData($data){
		file_put_contents($this->connection_json, json_encode($data));
		$this->updateDataValue();
	}
	
	public function readFile(){
		$data = file_get_contents($this->connection_json);
		return json_decode($data,true);
	}

	public function updateDataValue(){
		$this->data = $this->readFile();
	}
	
}