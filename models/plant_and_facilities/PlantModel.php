<?php

use Carbon\Carbon;

class Plant extends Database{
   private $account_id;
   public $bldgCoordinators;

  function __construct() {
      parent::__construct();
      $this->account_id = $_SESSION['account_id'];
  }

  public function setBldgCoordinators($arr){
    $this->bldgCoordinators = $arr;
  }

  public function getEventsApproval(){
    $sql = $this->getData("SELECT event_id FROM events WHERE status_id = 3");
    $event_arr = [];

    foreach($sql as $data){
      if($this->isBldgApproved($data->event_id) && is_null($this->isPlantApproved($data->event_id))){
        $event_arr[] = $data->event_id;
      }
    }

    $event_str = inSqlString($event_arr);

    $sql = $this->getData("SELECT * 
          FROM events e
          LEFT JOIN reservations r ON r.event_id = e.event_id
          LEFT JOIN venues v ON v.venue_id = r.venue_id
          WHERE e.removed = 0 
          AND e.event_id IN ($event_str)
          ");

    return $sql;
  }

  public function getEvents(){
    $sql = $this->getData("SELECT event_id FROM events");
    $event_arr = [];

    foreach($sql as $data){
      if($this->isBldgApproved($data->event_id)){
        $event_arr[] = $data->event_id;
      }
    }

    $event_str = inSqlString($event_arr);

    $sql = $this->getData("SELECT * 
          FROM events e
          LEFT JOIN reservations r ON r.event_id = e.event_id
          LEFT JOIN venues v ON v.venue_id = r.venue_id
          WHERE e.removed = 0 
          AND e.event_id IN ($event_str)
          ");

    return $sql;
  }

  public function isPlantApproved($event_id){
    $sql = $this->getData("SELECT approved FROM approvals WHERE event_id = '$event_id' AND account_id = '$this->account_id'");

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

      if(in_array('true', $array) && in_array('null', $array)) {
        return null;
      } elseif(in_array('false', $array)){
        return false;
      } else{
        return true;
      }
    }

    return $sql[0]->approved;
  }

  public function isBldgApproved($event_id){
    $sql = $this->getData("
                SELECT a.account_id, a.position_id, a.event_id, a.approved 
                FROM approvals a
                JOIN accounts acc ON acc.account_id = a.account_id
                JOIN employees e ON e.account_id = acc.account_id
                JOIN bldg_coordinators b ON b.employees_id = e.employees_id
                JOIN reservations r ON r.venue_id = b.venue_id
                WHERE r.event_id = '$event_id' AND a.event_id = '$event_id'
            ");

    $count = count($sql);

    if($count > 1){
      foreach($sql as $data){
        if($data->approved){
          return true;
        }
      }
    }

    if($sql[0]->approved){
      return true;
    }

    return false;
  }

  public function getHtmlFacilities($event_id, $return_count = false){
    $sql = $this->getData("SELECT * FROM reservations WHERE event_id = '$event_id'");

    $facility = $sql[0]->facility_item_id;
    $quantity = $sql[0]->item_quantity;

    $tbl = "";

    $tbl .= '<table cellspacing="0" cellpadding="3" border="1" style="width:100%">';
        $tbl .= '<tr>';
            $tbl .= '<th align="center" width="50%">Facility</th>';
            $tbl .= '<th align="center" width="25%">Type</th>';
            $tbl .= '<th align="center" width="25%">Quantity</th>';
        $tbl .= '</tr>';

    if(is_null($facility)){
      $tbl .= '<tr>';
          $tbl .= '<td colspan="3" align="center"><i>No item to show!</i></td>';
      $tbl .= '</tr>';
      $tbl .= '</table>';

      return $tbl;
    }

    $qty_arr = array_map('trim', array_filter(explode(',',$quantity)));

    if($return_count){
      return count($qty_arr);
    }

    unset($sql[0]->reservation_id);
    unset($sql[0]->event_id);
    unset($sql[0]->venue_id);
    unset($sql[0]->created_at);
    unset($sql[0]->updated_at);
    unset($sql[0]->removed);

    $sql = $this->getData("SELECT * FROM facility_items item JOIN facilities f ON f.facility_id = item.facility_id  WHERE item.facility_item_id IN ($facility)");

    $count = count($sql);


    for($i = 0; $i < $count; $i++){
        $tbl .= '<tr>';
            $tbl .= '<td>'. $sql[$i]->item .'</td>';
            $tbl .= '<td>'. $sql[$i]->facility .'</td>';
            $tbl .= '<td>'. $qty_arr[$i] .' pcs.</td>';
        $tbl .= '</tr>';
    }

    $tbl .= '</table>';

    return $tbl;
  }

  public function getEventInformation($event_id){
      $plant = new Plant;

      $sql = $this->getData("SELECT * FROM events e 
          JOIN reservations r ON r.event_id = e.event_id
          JOIN venues v ON v.venue_id = r.venue_id
          JOIN bldg_coordinators b ON b.venue_id = v.venue_id
          JOIN employees emp ON emp.employees_id = b.employees_id
          JOIN names n ON n.name_id = emp.name_id
          WHERE r.event_id = '$event_id'");

      // Date
      $raw_date = json_decode($sql[0]->date_of_use);
      $first_date = Carbon::createFromFormat('Y-m-d', reset($raw_date));
      $end_date = Carbon::createFromFormat('Y-m-d', end($raw_date));

      // Time
      $raw_time = explode('%', $sql[0]->inclusive_time);
      $first_time = Carbon::createFromFormat('H:i', reset($raw_time));
      $end_time = Carbon::createFromFormat('H:i', end($raw_time));

      if($first_date->isSameMonth($end_date)){
          if($first_date->isSameDay($end_date)){
              $sql[0]->date = $first_date->toFormattedDateString();
          } else{
              $first_day = $first_date->day;
              $last_day = $end_date->day;

              $sql[0]->date = "$first_date->shortEnglishMonth $first_day-$last_day, $first_date->year";
          }
      } else{
          $sql[0]->date = $first_date->toFormattedDateString() . "-" . $end_date->toFormattedDateString();
      }

      $sql[0]->time = $first_time->format('H:iA') . " - " . $end_time->format('H:iA');
      $sql[0]->bldg_coordinator_name = formatName($sql[0]->fname, $sql[0]->mname, $sql[0]->lname);

      unset($sql[0]->event_type_id);
      unset($sql[0]->attendance);
      unset($sql[0]->date_of_use);
      unset($sql[0]->inclusive_time);
      unset($sql[0]->recipient_department);
      unset($sql[0]->recipient_year_level);
      unset($sql[0]->status_id);
      unset($sql[0]->proposal);
      unset($sql[0]->account_id);
      unset($sql[0]->event_img);
      unset($sql[0]->created_at);
      unset($sql[0]->updated_at);
      unset($sql[0]->removed);
      unset($sql[0]->reservation_id);
      unset($sql[0]->facility_item_id);
      unset($sql[0]->item_quantity);
      unset($sql[0]->venue_id);
      unset($sql[0]->capacity);
      unset($sql[0]->price);
      unset($sql[0]->image_url);
      unset($sql[0]->signature);
      unset($sql[0]->name_id);
      unset($sql[0]->employee_id);
      unset($sql[0]->employees_id);
      unset($sql[0]->bldg_coordinator_id);
      unset($sql[0]->contact_id);
      unset($sql[0]->gender);
      unset($sql[0]->position_id);
      unset($sql[0]->fname);
      unset($sql[0]->mname);
      unset($sql[0]->lname);

      return $sql;
  }

  public function getSscAdminSignature(){
      $sql = $this->getData("SELECT e.signature 
          FROM employees e
          JOIN accounts a ON a.account_id = e.account_id
          WHERE e.position_id = 19 
          AND a.removed = 0");

      return $this->dec($sql[0]->signature);
  }

  public function getBldgCoordinatorSignature($event_id){
      $sql = $this->getData("SELECT a.account_id, e.signature 
          FROM bldg_coordinators b 
          JOIN employees e ON e.employees_id = b.employees_id
          JOIN accounts a ON a.account_id = e.account_id
          JOIN venues v ON v.venue_id = b.venue_id
          JOIN reservations r ON r.venue_id = v.venue_id
          JOIN events ON events.event_id = r.event_id
          WHERE a.removed = 0
          AND events.event_id = $event_id
          GROUP BY a.account_id
           ");

      if($sql){
          $account_id = $sql[0]->account_id;

          $sql1 = $this->getData("SELECT * FROM approvals WHERE event_id = $event_id AND account_id = $account_id");

          foreach($sql1 as $data) :
              if($data->approved == 1) :
                  return $this->dec($sql[0]->signature);
              endif;
          endforeach;
      }

      return;
  }

  public function getSscAdviserSignature(){
    $sql = $this->getData("
        SELECT e.signature FROM employees e 
        JOIN positions p ON p.position_id = e.position_id
        JOIN accounts a ON a.account_id = e.account_id
        WHERE p.position_id = 19
        AND a.removed = 0
      ");

    if($sql){
      if(count($sql) > 0){
        return $this->dec($sql[0]->signature);
      }
    }

    return;
  }

  public function getPlantSignature($event_id){

    $sql = $this->getData("SELECT * 
      FROM approvals a
      JOIN employees e ON e.position_id = a.position_id
      WHERE a.event_id = '$event_id'
      AND e.position_id = 11
      ");

    foreach($sql as $data){
      if(is_null($data->approved) || $data->approved == 0){
        return;
      }
    }
    
    return $this->dec($data->signature);
  }

  public function getPlantName(){
    $sql = $this->getData("SELECT * 
      FROM employees e 
      JOIN names n ON n.name_id = e.name_id 
      JOIN accounts a ON a.account_id = e.account_id
      WHERE e.position_id = 11 
      AND a.removed = 0
      ");

    unset($sql[0]->employees_id);
    unset($sql[0]->employee_id);
    unset($sql[0]->name_id);
    unset($sql[0]->position_id);
    unset($sql[0]->contact_id);
    unset($sql[0]->account_id);
    unset($sql[0]->gender);
    unset($sql[0]->signature);
    unset($sql[0]->created_at);
    unset($sql[0]->updated_at);
    unset($sql[0]->removed);
    unset($sql[0]->username);
    unset($sql[0]->password);
    unset($sql[0]->user_level_id);
    unset($sql[0]->activation_code);
    unset($sql[0]->activated);
    unset($sql[0]->account_img_url);

    return formatName($sql[0]->fname, $sql[0]->mname, $sql[0]->lname);
  }

  public function eventExists($event_id){
    $sql = $this->count("SELECT * FROM events WHERE event_id = '$event_id' AND removed = 0 ");

    if($sql == 0){
      return;
    }

    return true;
  }

  public function approveEvent($id){
    $sql = $this->query("UPDATE approvals SET approved = 1 WHERE event_id = '$id' AND account_id = '$this->account_id'");

    if($sql){
      return true;
    }

    return;
  }

  public function disapproveEvent($id){
    $sql = $this->query("UPDATE approvals SET approved = 0 WHERE event_id = '$id' AND account_id = '$this->account_id' AND approved IS NULL");

    if($sql){
      return true;
    }

    return;
  }

  public function getFacilities(){
    return $this->getData("SELECT * FROM facilities WHERE removed = 0");
  }

  public function facilityItemExists($item){
    $sql = $this->getData("SELECT COUNT(*) x FROM facility_items WHERE item = '$item'");

    if($sql[0]->x > 0){
      return true;
    }

    return false;
  }
}