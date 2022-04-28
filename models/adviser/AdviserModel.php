<?php

class Adviser extends Database{
	public function test(){
		return 'test';
	}

	public function positionIsOccupied($id){
		$sql = $this->getData("SELECT COUNT(*) total FROM ssc WHERE position_id = {$id} AND removed = 0");

		return $sql[0]->total > 0 ? true : false;
	}
}