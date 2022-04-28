<?php

use Carbon\Carbon;

class Layouts extends Database{
	private $account_id;

	function __construct() {
	    parent::__construct();

	    if(isset($_SESSION['account_id'])){
	    	$this->account_id = $_SESSION['account_id'];
	    }
	}

	public function getProfilePicture(){
		$sql = $this->getData("SELECT account_img_url FROM accounts WHERE account_id = {$this->account_id}");
		return assets($sql[0]->account_img_url);
	}

	public function getUndername(){
		if($this->isStudent()){
			return is_null($_SESSION['position']) ? $_SESSION['user_level'] : $_SESSION['position'] . ' | ' . $_SESSION['user_level'];
		}

		return $_SESSION['position'] . ' | ' . $_SESSION['office'] . ' | ' . $_SESSION['user_level'];
	}

	public function isStudent(){
		return (bool) $this->getData("SELECT COUNT(*) x FROM students WHERE account_id = {$this->account_id}")[0]->x;
	}

	public function getProfile(){
		$profile = [];
		
		$sql = $this->getData("
				SELECT a.username, a.account_img_url, a.account_cover_photo, a.facebook_account, a.twitter_account, a.instagram_account, a.about_me,
					COALESCE(n1.fname, n2.fname) fname, COALESCE(n1.mname, n2.mname) mname, COALESCE(n1.lname, n2.lname) lname, 
					COALESCE(c1.user_contact, c2.user_contact) user_contact, COALESCE(GREATEST(a.updated_at, c1.updated_at, n1.updated_at), GREATEST(a.updated_at, c2.updated_at, n2.updated_at)) updated_at
				FROM accounts a
				LEFT JOIN students s ON s.account_id = a.account_id
				LEFT JOIN employees e ON e.account_id = a.account_id
				LEFT JOIN names n1 ON n1.name_id = s.name_id
				LEFT JOIN names n2 ON n2.name_id = e.name_id
				LEFT JOIN contacts c1 ON c1.contact_id = s.contact_id
				LEFT JOIN contacts c2 ON c2.contact_id = e.contact_id
				WHERE a.account_id = {$this->account_id}
			");

		foreach($sql as $data){
			$profile['username'] = $data->username;
			$profile['account_img_url'] = assets($data->account_img_url);
			$profile['account_cover_photo'] = assets($data->account_cover_photo);
			$profile['facebook_account'] = $data->facebook_account;
			$profile['twitter_account'] = $data->twitter_account;
			$profile['instagram_account'] = $data->instagram_account;
			$profile['fname'] = $data->fname;
			$profile['mname'] = $data->mname;
			$profile['lname'] = $data->lname;
			$profile['about_me'] = $data->about_me;
			$profile['user_contact'] = $data->user_contact;
			$profile['updated_at'] = $data->updated_at == 0 ? '' : 'Last update: ' . Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->diffForHumans();
		}

		return $profile;
	}

	public function changeProfile($image){
		return $this->query("UPDATE accounts SET account_img_url = '$image' WHERE account_id = '$this->account_id'");
	}

	public function changeCover($image){
		return $this->query("UPDATE accounts SET account_cover_photo = '$image' WHERE account_id = '$this->account_id'");
	}

	public function isMyUsername($username){
		$sql = $this->getData("SELECT COUNT(*) x FROM accounts WHERE username = '$username' AND account_id = '$this->account_id'");

		if($sql[0]->x == 1){
			return true;
		}

		return false;
	}

	public function usernameExists($username){
		$sql = $this->getData("SELECT COUNT(*) x FROM accounts WHERE username = '$username'");

		return $sql[0]->x > 0 ? true : false;
	}
}