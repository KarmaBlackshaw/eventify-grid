<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class StudentAffairs extends Database{
	private $account_id;
    
	function __construct() {
        parent::__construct();
        $this->account_id = $_SESSION['account_id'];
    }

    public function test(){
        return "hey";
    }

    public function isOsaApproved($event_id){
        $sql = $this->getData("SELECT approved FROM approvals WHERE event_id = '$event_id' AND account_id = {$this->account_id}");

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

    public function getEventsApproval(){
      $plant = new Plant();
      $sql = $this->getData("SELECT event_id FROM events WHERE status_id = 3");
      $event_arr = [];

      foreach($sql as $data){
        if($plant->isBldgApproved($data->event_id) && is_null($this->isOsaApproved($data->event_id))){
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
      $ssc = new SSC();
      $sql = $this->getData("SELECT event_id FROM events WHERE removed = 0");
      $event_arr = [];

      foreach($sql as $data){
        if($ssc->checkSSCApproved($data->event_id)){
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

    public function approveEvent($event_id){
      $sql = $this->query("UPDATE approvals SET approved = 1 WHERE event_id = '$event_id' AND account_id = '$this->account_id'");

      return $sql;
    }

    public function disapproveEvent($event_id){
      $sql = $this->query("UPDATE approvals SET approved = 0 WHERE event_id = '$event_id' AND account_id = '$this->account_id'");

      return $sql;
    }
}