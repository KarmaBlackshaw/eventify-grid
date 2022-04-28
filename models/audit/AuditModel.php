<?php

use Carbon\Carbon;

class Audit extends Database{

	public $account_id;

	function __construct() {
        parent::__construct();
        $this->account_id = $_SESSION['account_id'];
    }

    public function audit($action){
        $position_id = empty($_SESSION['position_id']) ? 0 : $_SESSION['position_id'];
        $account_id = $_SESSION['account_id'];

        $sql = $this->query("INSERT INTO audit_trails(action, position_id, account_id) VALUES('$action', {$position_id}, {$account_id})");
        
        if($sql){
            return $sql;
        }

        return $this->error();
    }

    public function getUserAudits(){
        $sql = $this->getData("SELECT * FROM audit_trails WHERE account_id = {$this->account_id} ORDER BY audit_id DESC");

        foreach($sql as $data){
            $arr = $this->getNameFromAccountID($data->account_id);

            $data->created_at = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->diffForHumans();
            $data->name = $arr['name'];
            $data->id = $arr['id'];

            unset($data->account_id);
        }

        return $sql;
    }

    public function getNameFromAccountID($id){
        $json['name'] = NULL;
        $json['id'] = NULL;

        $sql = $this->getData("
                SELECT COALESCE(n1.fname, n2.fname) fname, COALESCE(n1.mname, n2.mname) mname, COALESCE(n1.lname, n2.lname) lname, COALESCE(s.student_id, e.employee_id) id
                FROM accounts a
                LEFT JOIN students s ON s.account_id = a.account_id
                LEFT JOIN employees e ON e.account_id = a.account_id
                LEFT JOIN names n1 ON n1.name_id = s.name_id
                LEFT JOIN names n2 ON n2.name_id = e.name_id
                WHERE a.account_id = {$id}
            ");

        if(!empty($sql)){
            $json['name'] = formatName($sql[0]->fname, $sql[0]->mname, $sql[0]->lname);
            $json['id'] = $sql[0]->id;
        }

        return $json;
    }
}