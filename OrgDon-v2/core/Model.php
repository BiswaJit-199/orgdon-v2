<?php
require_once '../config/config.php';
class Model {
	protected $database;
	public function __construct() {
		try {
			$database = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
			$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $pdoe) {
			echo 'Connection failed' . $pdoe->getMessage();
		}
		
		$this->database = $database;
	}
}
?>