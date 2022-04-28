<?php

use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Rah\Danpu\Dump;
use Rah\Danpu\Export;

class Database{

	protected $conn;
	protected $host;
	protected $user;
	protected $pass;
	protected $base;

	public function __construct(){
		$this->host = 'localhost';
		$this->user = 'root';
		$this->pass = '';
		$this->base = 'semms';
		$this->backup();
		$this->QR_System();
		$this->QR_Signature();
		
		try {
			return $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->base);
		} catch (Exception $e) {
			return $this->conn->error;
			die();
		}
		
	}

	public function post($query){
		$word = mysqli_real_escape_string($this->conn, $_POST[$query]);
		$word = htmlentities($word);
		$word = trim($word);
		return $word;
	}

	public function get($query){
		$word = mysqli_real_escape_string($this->conn, $_GET[$query]);
		$word = htmlentities($word);
		$word = trim($word);
		return $word;
	}

	public function query($query){
		$sql = $this->conn->query($query);
		return $sql;
	}

	public function count($query){
		$sql = $this->query($query);
		$rows = $sql->num_rows;
		return $rows;
	}

	public function insert_id(){
		return $this->conn->insert_id;
	}

	public function error(){
		return $this->conn->error;
	}

	public function getData($query){
		$sql = $this->query($query);
		$array = [];

		while($fetch = $sql->fetch_object()){
 			$array[] = $fetch;
 		}
 		
 		return $array;
	}

	private function gen_karma(){
		return base64_encode(md5('ErnieJeashCVillahermosa363369636'));
	}

	public function enc($data) {
		$key = $this->gen_karma();
	    $encryption_key = base64_decode($key);
	    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
	    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
	    return base64_encode($encrypted . '::' . $iv);
	}

	public function dec($data) {
		$key = $this->gen_karma();
	    $encryption_key = base64_decode($key);
	    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
	    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
	}

	public function QR_System(){
		$link = 'http://' . server_addr() . base . 'views/';
		$code = new QrCode($link);

		// header('Content-Type: '. $code->getContentType());
		$code->writeString();
		$code->writeFile(dirname(__DIR__) . '/assets/images/QR/QR_Code.png');
	}

	public function QR_Signature(){
		$link = 'http://' . server_addr() . base . 'views/signature.php';
		$code = new QrCode($link);

		// header('Content-Type: '. $code->getContentType());
		$code->writeString();
		$code->writeFile(dirname(__DIR__) . '/assets/images/QR/QR_Signature.png');
	}

	public function backup(){
		if(Carbon::now() == Carbon::now()->firstOfMonth()){
			try {
			    $dump = new Dump;
			    $dump
			        ->file(root . 'database/semms_' . Carbon::now()->toDateString() . '.sql')
			        ->dsn("mysql:dbname=$this->base;host=$this->host")
			        ->user($this->user)
			        ->pass($this->pass)
			        ->tmp(root . 'database/');

			    new Export($dump);
			} catch (Exception $e) {
			    echo 'Export failed with message: ' . $e->getMessage();
			}
		}
	}
}

$init = new Database;