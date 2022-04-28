<?php

use Carbon\Carbon;
use Stillat\Numeral\Languages\LanguageManager;
use Stillat\Numeral\Numeral;

class Student extends Database{
	 private $account_id;

	function __construct() {
	    parent::__construct();
	    $this->account_id = $_SESSION['account_id'];
	}

	public function getApprovedEvents($offset){
		$ssc = new SSC();

        $event_id = [];
        $sql = $this->getData("SELECT event_id FROM events WHERE removed = 0");

        foreach($sql as $data){
            if($ssc->isApproved($data->event_id)){
                 $event_id[] = $data->event_id;
             }
        }

        $str = inSqlString($event_id);

        return $this->getData("SELECT * FROM events WHERE event_id IN ($str) ORDER BY event_id DESC LIMIT 2 OFFSET {$offset}");


		// return $sql;
	}

    public function getNumeralReacts($event_id){
        $languageManager = new LanguageManager;
        $formatter = new Numeral;
        $formatter->setLanguageManager($languageManager);

        $count = $this->getData("SELECT count(*) reacts FROM reactions WHERE event_id = $event_id AND removed = 0");

        return $formatter->format($count[0]->reacts, '0a');
    }

    public function react($react, $event_id){
    	$countSQL = $this->getData("SELECT count(*) a FROM reactions WHERE event_id = {$event_id} AND account_id = {$this->account_id} ");

    	if($countSQL[0]->a == 0){
    		return $this->query("INSERT INTO reactions(event_id, account_id, reaction) VALUES('$event_id', {$this->account_id}, {$react})");
    	} else{
    		return $this->query("UPDATE reactions SET reaction = $react WHERE event_id = '$event_id' AND account_id = {$this->account_id}");
    	}
    }

    public function getReact($event_id){
    	$sql = $this->getData("SELECT reaction FROM reactions WHERE event_id = '$event_id' AND account_id = {$this->account_id}");
    	
    	if($sql){
    		return $sql[0]->reaction;
    	}

    	return null;
    }


    public function comment($comment, $event_id){
        return $this->query("INSERT INTO comments(comment, event_id, account_id) VALUES('$comment', '$event_id', {$this->account_id})");
    }

    public function load_comments($event_id, $offset = 0){
        // $sql = $this->getData("
        //         SELECT c.comment, a.account_img_url, c.created_at 
        //         FROM comments c
        //         JOIN accounts a ON a.account_id = c.account_id
                // WHERE c.event_id = {$event_id} 
                // ORDER BY c.comment_id DESC
                // LIMIT 2 
                // OFFSET {$offset}
        //     ");

        $sql = $this->getData("
                SELECT c.comment, a.account_img_url, c.created_at, COALESCE(n1.fname, n2.fname) first_name, COALESCE(n1.mname, n2.mname) middle_name, COALESCE(n1.lname, n2.lname) last_name
                FROM comments c
                JOIN accounts a ON a.account_id = c.account_id
                LEFT JOIN employees e ON e.account_id = a.account_id
                LEFT JOIN students s ON s.account_id = a.account_id
                LEFT JOIN names n1 ON n1.name_id = e.name_id
                LEFT JOIN names n2 ON n2.name_id = s.name_id
                WHERE c.event_id = {$event_id} 
                ORDER BY c.comment_id DESC
                LIMIT 2 
                OFFSET {$offset}
            ");

        foreach($sql as $data){
            $data->numeral = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->diffForHumans();
            $data->account_img_url = assets($data->account_img_url);
            $data->name = formatName($data->first_name, $data->middle_name, $data->last_name);
        }

        return $sql;
    }

    public function getCommentCount($event_id){
        $sql = $this->getData("SELECT count(*) x FROM comments WHERE event_id = {$event_id}");
        return $sql[0]->x;
    }

    public function getMyStudentID(){
        $sql = $this->getData("
                SELECT s.students_id 
                FROM students s JOIN accounts a ON a.account_id = s.account_id 
                WHERE a.account_id = '$this->account_id'
            ");

        return $sql[0]->students_id;
    }
}