<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SSC extends Database{
	private $account_id;
    public $ssc_positions;
    
	function __construct() {
        parent::__construct();
        if(isset($_SESSION['account_id'])){
            $this->account_id = $_SESSION['account_id'];
        }
    }

    public function sscCompleteCheck(){
    	$sql = $this->count("SELECT p.position_id 
			FROM positions p 
			LEFT JOIN ssc s ON s.position_id = p.position_id AND s.removed = 0
			LEFT JOIN students stud ON stud.students_id = s.students_id
			LEFT JOIN accounts a ON a.account_id = stud.account_id
			WHERE p.user_level_id = 6 
			AND p.removed = 0 
			AND a.account_id IS NULL
			");

    	return $sql > 0 ? 0 : 1;
    }

    public function getOsaAccountID(){
    	$sql = $this->getData("
            SELECT a.account_id , c.user_contact
            FROM employees e 
            LEFT JOIN contacts c ON c.contact_id = e.contact_id
    		LEFT JOIN positions p ON e.position_id = p.position_id 
    		LEFT JOIN accounts a ON a.account_id = e.account_id
    		WHERE p.position_id = 22 
    		AND a.account_id IS NOT NULL
    		AND a.removed = 0");

        $count = count($sql);

        if(!empty($sql)){
            $sql[0]->position_id = 22;
            $sql[0]->user_contact = $sql[0]->user_contact;
            return $sql[0];
        }

    	return;
    }

    public function getBldgCoordinatorAccountID($bldg){
    	$sql = $this->getData("
            SELECT a.account_id, p.position_id  
            FROM employees e 
    		LEFT JOIN accounts a ON a.account_id = e.account_id AND a.removed = 0
    		LEFT JOIN positions p ON p.position_id = e.position_id
    		LEFT JOIN bldg_coordinators b ON b.employees_id = e.employees_id AND b.removed = 0
            LEFT JOIN contacts c ON c.contact_id = e.contact_id
    		WHERE a.account_id IS NOT NULL 
    		AND b.venue_id = '$bldg' 
    		AND a.removed = 0");

        if(!empty($sql)){
            return $sql[0];
        }

        return;
    }

    public function getPlantAccountID(){
    	$sql = $this->getData("
            SELECT a.account_id, c.user_contact 
            FROM employees e 
    		LEFT JOIN positions p ON e.position_id = p.position_id 
    		LEFT JOIN accounts a ON a.account_id = e.account_id
            LEFT JOIN contacts c ON c.contact_id = e.contact_id
    		WHERE p.position_id = 11 
    		AND a.account_id IS NOT NULL
    		AND a.removed = 0
        ");

        if(!empty($sql)){
            $sql[0]->position_id = 11;
            $sql[0]->user_contact = $sql[0]->user_contact;
            return $sql[0];
        }

        return;
    }

    public function getAllSSCMembers(){
    	$sql = $this->getData("
            SELECT p.position_id, a.account_id, c.user_contact 
    		FROM positions p 
    		LEFT JOIN ssc s ON s.position_id = p.position_id AND s.removed = 0
    		LEFT JOIN students stud ON stud.students_id = s.students_id
    		LEFT JOIN accounts a ON a.account_id = stud.account_id
            LEFT JOIN contacts c ON c.contact_id = stud.contact_id
    		WHERE p.user_level_id = 6 
    		AND p.removed = 0
    		AND a.removed = 0
        ");

    	return $sql;
    }

    public function getSSCSecretary(){
    	$sql = $this->getData("
            SELECT p.position_id, a.account_id, c.user_contact 
			FROM positions p 
			LEFT JOIN ssc s ON s.position_id = p.position_id AND s.removed = 0
			LEFT JOIN students stud ON stud.students_id = s.students_id
			LEFT JOIN accounts a ON a.account_id = stud.account_id
            LEFT JOIN contacts c ON c.contact_id = stud.contact_id
			WHERE p.user_level_id = 6 
			AND p.removed = 0
			AND p.position_id = 3
			AND a.removed = 0
        ");

    	return $sql;
    }

    public function insertApprovers($money, $venue_id, $event_id){
        $sql = $money == 1 ? $this->getAllSSCMembers() : $this->getSSCSecretary();
        $sql[count($sql)] = $this->getOsaAccountID();
        $sql[count($sql)] = $this->getBldgCoordinatorAccountID($venue_id);
        $sql[count($sql)] = $this->getPlantAccountID();

        $count = count($sql);
        $approvers_string = '';

        for($i = 0; $i < $count; $i++){
            $approvers_string .= "($event_id, {$sql[$i]->account_id}, {$sql[$i]->position_id}), ";
        }

        $approvers_string = rtrim(rtrim($approvers_string, ' '), ',');

        $sql = $this->query("INSERT INTO approvals(event_id, account_id, position_id) VALUES $approvers_string");
        return $sql;
    }

    public static function periodToArray($start, $end){
		$period = CarbonPeriod::create($start, $end);
		$arr = [];

		foreach ($period as $date) {
		    $arr[] = $date->format('Y-m-d');
		}

		return $arr;
	}

	public function checkApproval($event_id){
		$count = $this->count("SELECT * 
			FROM approvals 
			WHERE event_id = $event_id AND approved = 0 
			OR event_id = $event_id AND approved IS NULL");

		return $count == 0 ? 1 : 0;
	}

	public function getFormattedName($account_id){
		$sql = $this->getData("
            SELECT n.fname, n.mname, n.lname 
			FROM students s 
			JOIN accounts a ON a.account_id = s.account_id
			JOIN names n ON n.name_id = s.name_id 
			WHERE a.account_id = '$account_id'
        ");

		return formatName($sql[0]->fname, $sql[0]->mname, $sql[0]->lname);
	}

	public function approveEvent($event){
		$sql = $this->query("UPDATE approvals SET approved = 1 WHERE event_id = '$event' AND account_id = {$this->account_id}");

		return $sql == TRUE ? 1 : 0;
	}

	public function disapproveEvent($event){
		$sql = $this->query("UPDATE approvals SET approved = 0 WHERE event_id = '$event' AND account_id = {$this->account_id}");

		return $sql == TRUE ? 1 : 0;
	}

	public function getSscAdviserName(){
		$sql = $this->getData("SELECT n.fname, n.mname, n.lname 
			FROM employees e 
			JOIN positions p ON p.position_id = e.position_id 
			JOIN names n ON n.name_id = e.name_id 
			JOIN accounts a ON a.account_id = e.account_id 
			WHERE a.removed = 0 
			AND p.position_id = 19 ");

		$middle = acronym($sql[0]->mname) == ''  ? '' : acronym($sql[0]->mname) . '.';
		$fullname = $sql[0]->fname . ' ' . $middle . ' ' . $sql[0]->lname;

		return $fullname;
	}

    public function checkSelfEventStatus($event_id){
        $sql = $this->getData("SELECT approved FROM approvals WHERE account_id = {$this->account_id} AND event_id = '$event_id'");

        if(count($sql) == 0){
            return (bool)0;
        }

        return $status = $sql[0]->approved;
        
    }

    public function getEvent($event_id){
        $sql = $this->getData("SELECT event, created_at FROM events WHERE event_id = '$event_id'");

        return $sql;
    }

    public function getApprovalsPDF($event_id){
            $sql = $this->getData("
                SELECT app.approved, p.position, n.fname, n.mname, n.lname, o.office, COALESCE(e.signature, ssc.signature) AS signature
                FROM approvals app
                LEFT JOIN positions p ON p.position_id = app.position_id
                LEFT JOIN accounts a ON a.account_id = app.account_id
                LEFT JOIN employees e ON e.account_id = a.account_id
                LEFT JOIN students s ON s.account_id = a.account_id
                LEFT JOIN ssc ON ssc.students_id = s.students_id AND ssc.removed = 0
                LEFT JOIN names n ON n.name_id = s.name_id OR n.name_id = e.name_id
                LEFT JOIN offices o ON o.office_id = p.office_id
                WHERE app.event_id = '$event_id'
            ");

            return $sql;
    }

    public function item_title(){
        return "Hold down the control (ctrl) button to select multiple options";
    }

    public function facility_audio(){
        $sql = $this->getData("SELECT facility_item_id, item FROM facility_items WHERE facility_id = '1' AND quantity <> 0");

        return $sql;
    }

    public function facility_video(){
        $sql = $this->getData("SELECT facility_item_id, item FROM facility_items WHERE facility_id = '2' AND quantity <> 0");

        return $sql;
    }

    public function facility_lighting(){
        $sql = $this->getData("SELECT facility_item_id, item FROM facility_items WHERE facility_id = '3' AND quantity <> 0");

        return $sql;
    }

    public function departments(){
        $sql = $this->getData("SELECT department_id, department FROM departments WHERE removed = 0");

        return $sql;
    }

    public function event_types(){
        $sql = $this->getData("SELECT event_type_id, type FROM event_types WHERE removed = 0");

        return $sql;
    }

    public function total_events(){
        return $sql = $this->count("SELECT * FROM events WHERE removed = 0");
    }

    public function total_registered_students(){
        return $sql = $this->count("SELECT a.activated FROM students s JOIN accounts a ON a.account_id = s.account_id WHERE a.activated = 1");
    }

    public function total_events_month(){
        $now = Carbon::now()->format('Y-m');

        return $sql = $this->count("SELECT * FROM events WHERE date_of_use LIKE '%$now%'");
    }

    public function checkSSCApproved($event){
        $str = "";

        foreach($this->getAllSSCMembers() as $data){
            $str .= "'$data->position_id',";
        }

        $ssc_pos = "(" . rtrim($str, ',') . ")";
        $secretary_pos = $this->getSSCSecretary()[0]->position_id;
        
        $count = $this->count("SELECT * FROM approvals WHERE event_id = $event");

        if($count == 4){
            $approved = $this->getData("SELECT approved FROM approvals WHERE event_id = $event AND position_id = 3")[0]->approved;

            if(is_null($approved) || $approved === 0){
                return false;
            }
            return true;
        } else{
            $approved = $this->getData("SELECT approved FROM approvals WHERE event_id = $event AND position_id IN $ssc_pos");

            foreach($approved as $data){
                if(is_null($data->approved) || $data->approved == 0){
                    return false;
                }
            }

            return true;
        }
    }

    public function updateEventStatus($date_start, $date_end, $event_id){
        $start = Carbon::createFromFormat('Y-m-d', $date_start);
        $end = Carbon::createFromFormat('Y-m-d', $date_end);

        if($end->isPast() && !$end->isToday()){
            if(!$this->checkApproval($event_id)){
                $update_status = $this->query("UPDATE events SET status_id = 1 WHERE event_id = '$event_id'"); // Finished (Disapproved)
            } else{
                $update_status = $this->query("UPDATE events SET status_id = 2 WHERE event_id = '$event_id'"); // Finished
            }
        } elseif($start->isFuture()){
            if(!$this->checkApproval($event_id)){
                $update_status = $this->query("UPDATE events SET status_id = 3 WHERE event_id = '$event_id'"); // Pending
            } else{
                $update_status = $this->query("UPDATE events SET status_id = 4 WHERE event_id = '$event_id'"); // Approved
            }
        } else{
            if(!$this->checkApproval($event_id)){
                $update_status = $this->query("UPDATE events SET status_id = 5 WHERE event_id = '$event_id'"); // On-going (Disapproved)
            } else{
                $update_status = $this->query("UPDATE events SET status_id = 6 WHERE event_id = '$event_id'"); // On-Going
            }
        }
    }

    public function getStatusBadge($id, $statuses = ''){
        $sql = $this->getData("SELECT * FROM status WHERE status_id = '$id'");
        $status = $sql[0]->status;
        switch ($id) {
            case 1: // Finished (Disapproved)
                return '<span class="badge hvr-grow bg-red-light p-1 no-highlight d-block m-1">'. $status .'</span>';
                break;
            case 2: // Finished
                return '<span class="badge hvr-grow bg-azure p-1 no-highlight d-block m-1">'. $status .'</span>';
                break;
            case 3: // Pending
                return '<span class="badge hvr-grow bg-orange p-1 no-highlight d-block m-1">'. $status .'</span>';
                break;
            case 4: // Approved
                return '<span class="badge hvr-grow bg-green p-1 no-highlight d-block m-1">'. $status .'</span>';
                break;
            case 5: // On-going (Disapproved)
                return '<span class="badge hvr-grow bg-red p-1 no-highlight d-block m-1">'. $status .'</span>';
                break;
            case 6: // On-Going
                return '<span class="badge hvr-grow bg-blue p-1 no-highlight d-block m-1">'. $status .'</span>';
                break;
            default: // Unknown
                return '<span class="badge hvr-grow bg-gray p-1 no-highlight d-block m-1">'. $status .'</span>';
                break;
        }
    }

    public function deleteEvent($event_id){
        $sql = $this->query("DELETE e, a, r FROM events e JOIN approvals a ON e.event_id = a.event_id JOIN reservations r ON r.event_id = e.event_id WHERE e.event_id = '$event_id'");

        return $sql;
    }

    public function reserve($item_id, $quantity, $event_id, $venue_id){
        $item_count = count($item_id);
        $item_string = '';
        $quantity_string = '';

        for($i = 0; $i < $item_count; $i++){
            $item_temp = $item_id[$i];
            $qty_temp = $quantity[$i];

            $item_string .= "$item_temp, ";
            $quantity_string .= "$qty_temp, ";
        }

        $item_string = rtrim(rtrim($item_string, ' '), ',');
        $quantity_string = rtrim(rtrim($quantity_string, ' '), ',');

        return $reservation_sql = $this->query("INSERT INTO reservations(event_id, facility_item_id, item_quantity, venue_id) VALUES('$event_id', '$item_string', '$quantity_string', '$venue_id')");
        
    }

    public function test_reset(){
        $sql = $this->query("TRUNCATE events");
        $sql = $this->query("TRUNCATE approvals");
        $sql = $this->query("TRUNCATE reservations");
    }

    public function approve_all_ssc($id){
        $sql = $this->query("UPDATE approvals SET approved = 1 WHERE position_id < 11 AND event_id = $id ");

        if($sql){
            return true;
        }
    }

    public function isApproved($event_id){
        $count = $this->count("SELECT * FROM approvals WHERE (event_id = $event_id AND approved = 0) OR (approved IS NULL AND event_id = $event_id)");
        
        if($count == 0){
            return true;
        }
        return false;
    }

    public function getStatuses(){
        return $this->getData("SELECT status_id, status FROM status WHERE removed = 0");
    }

    public function getActiveStudents(){
        $sql = $this->getData("
            SELECT *
            FROM students s
            JOIN accounts a ON a.account_id = s.account_id
            JOIN names n ON n.name_id = s.name_id
            JOIN departments d ON d.department_id = s.department_id
            WHERE a.activated = 1
            AND a.removed = 0
            ");

        return $sql;
    }

    public function getApprovedEvents(){
        $sql = $this->getData("
               SELECT *
               FROM events e
               JOIN event_types t ON t.event_type_id = e.event_type_id
               WHERE e.removed = 0 
            ");

        foreach($sql as $key => $val){
           if(!$this->isApproved($sql[$key]->event_id)){
            unset($sql[$key]);
           }
        }

        return $sql;
    }

    // Biometrics
    public function getBiometricData($file){
        $file = file($file, FILE_IGNORE_NEW_LINES);
        $data = [];

        unset($file[0]);
        unset($file[1]);

        foreach($file as $files){
            $explode = explode(' ', $files);

            $first_explode = preg_split('/\s+/', $explode[0]);
            
            $data['student_id'][] = $first_explode[2];
            $data['name'][] = $first_explode[3];
            $data['time'][] = end($explode);
            $explode1 = $explode[count($explode) - 3];
            $second_explode = preg_split('/\s+/', $explode1);
            $data['date'][] = $second_explode[count($second_explode) - 1];
        }

        $final_arr = [];
        $time_in = array_unique($data['student_id']);
        $time_out = array_unique(array_reverse($data['student_id']));

        $arr = [];

        foreach($time_in as $key => $val){
            $arr['student_id'][] = substr($val, 2);
            $arr['date'][] = $data['date'][$key];
            $arr['time_in'][] = $data['time'][$key];
        }

        foreach ($time_out as $key => $value) {
            $arr['time_out'][] = array_reverse($data['time'])[$key];
        }

        return $arr;
    }

    public function biometricDataExists($event_id, $student_id, $date){
        $test = $this->getData("SELECT COUNT(*) x FROM attendance WHERE event_id = '$event_id' AND event_date = '$date' AND student_id = '$student_id'");

        if($test[0]->x > 0){
            return true;
        }

        return false;
    }

    public function biometricDateMatches($event_id, $date){
        $sql = $this->getData("SELECT COUNT(*) x FROM events WHERE event_id = '$event_id' AND date_of_use LIKE '%$date%'");

        if($sql[0]->x != 0){
            return true;
        }

        return false;
    }

    public function getRecipients($department, $year_level){
        $sql = $this->getData("SELECT * FROM departments WHERE department_id IN ($department)");

        $year_level = array_map('trim', explode(',', $year_level));
        $json = [];

        foreach($sql as $dep){
            foreach($year_level as $year){
                $json[] = ordinal($year) . ' Years of ' . $dep->department;
            }
        }

        return $json;
    }

    public function getStudentInformation($id){
        $sql = $this->getData("
                SELECT s.year_level, d.department, d.department_id, n.fname, n.mname, n.lname, s.student_id 
                FROM students s 
                JOIN departments d ON d.department_id = s.department_id
                JOIN names n ON n.name_id = s.name_id
                WHERE s.students_id = $id
            ");

        $data = [];

        if(!empty($sql)){
            $data['year_level_formatted'] = ordinal($sql[0]->year_level) . " Year";
            $data['year_level'] = $sql[0]->year_level;
            $data['department_id'] = $sql[0]->department_id;
            $data['name'] = formatName($sql[0]->fname, $sql[0]->mname, $sql[0]->lname);
            $data['student_id'] = $sql[0]->student_id;
            $data['department'] = $sql[0]->department;
        }

        return $data;
    }

    public function getStudentEvents($id){
        $info = $this->getStudentInformation($id);
        $arr = [];

        $events = $this->getData("
                SELECT * 
                FROM events 
                WHERE recipient_year_level LIKE '%{$info['year_level']}%'
                AND recipient_department LIKE '%{$info['department_id']}%'
                ORDER BY event_id DESC
            ");

        foreach($events as $data){
            $explode = json_decode($data->date_of_use);
            rsort($explode);

            foreach($explode as $date){
                $arr['event_id'][] = $data->event_id;
                $arr['event'][] = $data->event;
                $arr['date'][] = $date;
                $arr['date_formatted'][] = Carbon::createFromFormat('Y-m-d', $date)->format('F d, Y');
                $arr['time'][] = formatTime($data->inclusive_time);
            }
        }

        return $arr;
    }

    public function getTime($event_id, $student_id, $date){
        $sql = $this->getData("SELECT * FROM attendance WHERE event_id = '$event_id' AND student_id = '$student_id' AND event_date = '$date'");

        $json['in'] = NULL;
        $json['out'] = NULL;

        if(!empty($sql)){

            if($sql[0]->time_in == 1){
                $json['in'] = "<small>Cleared</small>";
                $json['out'] = "<small>Cleared</small>";
            } else{
                $json['in'] = Carbon::createFromFormat('H:i:s', $sql[0]->time_in)->format('h:iA');
                $json['out'] = Carbon::createFromFormat('H:i:s', $sql[0]->time_out)->format('h:iA');
            }
        }

        return $json;
    }

    public function getStudentReportBadge($time){
        if(is_null($time['in'])){
            return '<span class="badge hvr-grow bg-red-light p-1 no-highlight d-block m-1">Absent</span>';
        } 
        
        return '<span class="badge hvr-grow bg-green-light p-1 no-highlight d-block m-1">Present</span>';
    }

    // SMS and Numbers
    public static function sms($numbers, $message){
        $username = "irenesejah29@gmail.com";
        $hash = "18293bde97a951eadc0c605f970a968583bf2c5b1531e4bc8c10da69092b70a5";
        $test = "0";
        $sender = "LNU Supreme Student Council"; 

        $numbers = array_map('trim', $numbers);
        $numbers = array_map('formatPhoneNumber', $numbers);
        $num_string = implode(',', $numbers);

        // 612 chars or less
        // A single number or a comma-seperated list of numbers (can send bulk with commmaaaa)

        $message = urlencode($message);
        $data = "username=$username&hash=$hash&message=$message&sender=$sender&numbers=$num_string&test=$test";
        $ch = curl_init('http://api.txtlocal.com/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        return $result->status == 'success' ? true : false;
    }

    public function notifySSC($message){
        $ssc = $this->getAllSSCMembers();
        $json = [];

        foreach($ssc as $data){
            $json[] = $data->user_contact;
        }

        return SSC::sms($json, $message);
    }

    public function getEventRecipientNumbers($event_id){
        $numbers = [];

        $event_sql = $this->getData("SELECT recipient_department, recipient_year_level FROM events WHERE event_id = '$event_id'");

        if(!empty($event_sql)){
            $department = $event_sql[0]->recipient_department;
            $year_level = $event_sql[0]->recipient_year_level;
        }

        $sql = $this->getData("
            SELECT c.user_contact
            FROM students s
            LEFT JOIN contacts c ON c.contact_id = s.contact_id
            WHERE s.department_id IN ($department) 
            AND s.year_level IN ($year_level)");

        foreach($sql as $data){
            $numbers[] = $data->user_contact;
        }

        return array_unique(array_filter($numbers));
    }

    public function getEventBldgCoordinator($event_id){
        $sql = $this->getData("
                SELECT c.user_contact
                FROM events e 
                LEFT JOIN reservations r ON r.event_id = e.event_id
                LEFT JOIN bldg_coordinators b ON b.venue_id = r.venue_id
                LEFT JOIN employees emp ON emp.employees_id = b.employees_id
                LEFT JOIN contacts c ON c.contact_id = emp.contact_id
                WHERE e.event_id = '$event_id';
            ");

        return $sql[0]->user_contact;
    }
}