<?php

class MIS extends Database{
	private $account_id;

	function __construct() {
		parent::__construct();

		if(isset($_SESSION['account_id'])){
			$this->account_id = $_SESSION['account_id'];	
		}
	}

	public function getStudents($id = ''){
		$query = "
			SELECT *
			FROM students s
			JOIN accounts a ON a.account_id = s.account_id 
			JOIN names n ON n.name_id = s.name_id
			JOIN departments d ON d.department_id = s.department_id
			JOIN contacts c ON c.contact_id = s.contact_id
			WHERE a.removed = 0 
		";

		if(!empty($id)){
			$query .= "AND s.student_id  = '$id'";
		}

		$sql = $this->getData($query);

		return $sql;
	}

	public function getColleges(){
		return $this->getData("SELECT * FROM departments WHERE removed = 0");
	}

	public function studentExists($id){
		$sql = $this->getData("SELECT COUNT(*) x FROM students WHERE student_id = '$id'");

		return $sql[0]->x > 0 ? true : false;
	}

	public function insertName($fname, $mname, $lname){
		$sql = $this->query("INSERT INTO names(fname, mname, lname) VALUES('$fname', '$mname', '$lname')");
		return $this->insert_id();
	}

	public function insertContact($number){
		$sql = $this->query("INSERT INTO contacts(user_contact) VALUES('$number')");
		return $this->insert_id();
	}

	public function insertAccount($user_level_id, $code, $profile){
		$sql = $this->query("INSERT INTO accounts(user_level_id, activation_code, account_img_url) VALUES('$user_level_id', '$code', '$profile')");
		return $this->insert_id(); 
	}
}