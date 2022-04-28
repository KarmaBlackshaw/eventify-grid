<?php

class Bldg extends Database{
	private $account_id;

	function __construct() {
        parent::__construct();
        $this->account_id = $_SESSION['account_id'];
    }

    public function checkSelfApproval($event_id){
    	$sql = $this->getData("SELECT approved FROM approvals WHERE event_id = $event_id AND account_id = {$this->account_id}");

    	$count = count($sql);

        if($count > 1){
          $arr['null'] = $arr['true'] = $arr['false'] = 0;

          foreach($sql as $data){
            $approved = $data->approved;
            if($approved == 1){
              $arr['true'] += 1;
            } elseif(is_null($approved)){
              $arr['null'] += 1;
            } else{
              $arr['false'] += 1;
            }
          }

          $array = array_keys($arr, max($arr));
          
          if(count($array) == 1){
            if(is_null($array[0]) || $array[0] == 'null'){
                return null;
            }
          }

          if(in_array('true', $array) && in_array('null', $array)) {
            return true;
          } elseif(in_array('false', $array)){
            return false;
          } elseif(in_array(null, $array)){
            return null;
          } else{
            return true;
          }
        }

        return $sql[0]->approved;
    }

    public function getBldgCoordinators(){
        $sql = $this->getData("SELECT * 
            FROM bldg_coordinators b 
            JOIN employees e ON e.employees_id = b.employees_id
            JOIN accounts a ON a.account_id = e.account_id
            WHERE b.removed = 0
            GROUP BY b.employees_id
            ");

        $bldg_arr = [];

        foreach($sql as $data){
            $bldg_arr[] = $data->account_id;
        }

        return $bldg_arr;
    }

    public function getEvents(){
        $ssc = new SSC;

        $sql_events = $this->getData("SELECT event_id FROM events WHERE removed = 0");
        $events_arr = [];
        $str_events = [];

        foreach($sql_events as $data){
            if($ssc->checkSSCApproved($data->event_id)){
                $str_events[] = $data->event_id;
            }
        }

        $str_events = inSqlString($str_events);

        return $this->getData("SELECT e.event_id, e.event, e.event_type_id, e.attendance, e.recipient_department, e.recipient_year_level, e.status_id, e.requesting_party, e.date_of_use, e.inclusive_time, e.event_img, v.venue, r.facility_item_id, s.status
            FROM events e
            LEFT JOIN reservations r ON r.event_id = e.event_id
            LEFT JOIN venues v ON v.venue_id = r.venue_id
            LEFT JOIN facility_items items ON items.facility_item_id = r.facility_item_id
            LEFT JOIN bldg_coordinators b ON b.venue_id = v.venue_id
            LEFT JOIN status s ON s.status_id = e.status_id 
            WHERE e.event_id IN ($str_events)
            AND b.employees_id = {$_SESSION['employees_id']}
        ");
    }

    public function getEventsForApproval(){
    	$ssc = new SSC;

    	$sql_events = $this->getData("SELECT event_id FROM events WHERE removed = 0 AND status_id = 3");
    	$str_events = "";

    	foreach($sql_events as $data){
    		if($ssc->checkSSCApproved($data->event_id) && is_null($this->checkSelfApproval($data->event_id))){
    			$str_events .= "'$data->event_id',";
    		}
    	}

    	$str_events = (rtrim($str_events, ',') == '') ? "''" : rtrim($str_events, ',');

    	return $this->getData("SELECT e.event_id, e.event, e.event_type_id, e.attendance, e.recipient_department, e.recipient_year_level, e.status_id, e.requesting_party, e.date_of_use, e.inclusive_time, e.event_img, v.venue, r.facility_item_id
    		FROM events e
    		LEFT JOIN reservations r ON r.event_id = e.event_id
    		LEFT JOIN venues v ON v.venue_id = r.venue_id
    		LEFT JOIN facility_items items ON items.facility_item_id = r.facility_item_id
    		LEFT JOIN bldg_coordinators b ON b.venue_id = v.venue_id
    		WHERE e.event_id IN ($str_events)
    		AND b.employees_id = {$_SESSION['employees_id']}
 		");
    }

    // public function getMyEvents($event){
    // 	$ssc = new SSC;
    //     $str = "";

    //     foreach($ssc->getAllSSCMembers() as $data){
    //         $str .= "'$data->position_id',";
    //     }

    //     $ssc_pos = "(" . rtrim($str, ',') . ")";
    //     $secretary_pos = $ssc->getSSCSecretary()[0]->position_id;
        
    //     $count = $this->count("SELECT * FROM approvals WHERE event_id = $event");

    //     if($count == 4){
    //         $approved = $this->getData("SELECT approved FROM approvals WHERE event_id = $event AND position_id = 3")[0]->approved;

    //         if(is_null($approved) || $approved === 0){
    //             return false;
    //         }
    //         return true;
    //     } else{
    //         $approved = $this->getData("SELECT approved FROM approvals WHERE event_id = $event AND position_id IN $ssc_pos");

    //         foreach($approved as $data){
    //             if(is_null($data->approved) || $data->approved == 0){
    //                 return false;
    //             }
    //         }

    //         return true;
    //     }
    // }

    public function getEventInfo($event){
    	$query = "SELECT e.event_id, e.event, e.event_type_id, e.attendance, e.recipient_department, e.recipient_year_level, e.status_id, e.requesting_party, e.date_of_use, e.inclusive_time, e.event_img, v.venue, r.facility_item_id, r.item_quantity
    		FROM events e
    		LEFT JOIN reservations r ON r.event_id = e.event_id
    		LEFT JOIN venues v ON v.venue_id = r.venue_id
    		LEFT JOIN facility_items items ON items.facility_item_id = r.facility_item_id
    		LEFT JOIN bldg_coordinators b ON b.venue_id = v.venue_id
    		WHERE e.event_id = '$event'
    		";

    	return $sql = $this->getData($query);
    }

    public function getMyBuildings(){
        $sql = $this->getData("SELECT * 
            FROM bldg_coordinators b 
            LEFT JOIN venues v  ON v.venue_id = b.venue_id
            WHERE b.employees_id = {$_SESSION['employees_id']}
            AND v.removed = 0
            ");

        return $sql;
    }

    public function getBuildingInfo($venue_id){
        $sql = $this->getData("SELECT * FROM venues v WHERE v.venue_id = '$venue_id'");

        return $sql;
    }

    public function getYears(){
        return $this->getData("SELECT DATE_FORMAT(created_at, '%Y') years FROM reservations WHERE removed = 0 GROUP BY years");
    }
}
