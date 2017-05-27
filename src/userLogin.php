<?php
error_reporting(E_ALL);
require_once('dbconfig.php');

class USER {	

	private $conn;
	
	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql) {
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
		
	
	public function doLogin($uname,$utype,$upass) {
		try {
			$stmt = $this->conn->prepare("SELECT user_id, user_name, user_type, user_pass FROM users WHERE (user_name=:uname) AND (user_type=:utype) ");
			$stmt->execute(array(':uname'=>$uname, ':utype'=>$utype));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1) {
				// $_SESSION['user_session'] = $userRow['user_id'];
				// $_SESSION['userType_session'] = $userRow['user_type'];

				if($upass == $userRow['user_pass']) {
					$_SESSION['user_session'] = $userRow['user_id'];
					$_SESSION['userType_session'] = $userRow['user_type'];
					return true;
				} else {
					return false;
				}
			}
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function is_loggedin() {
		if(isset($_SESSION['user_session'])) {
			return true;
		}
	}
	
	public function redirect($url) {
		header("Location: $url");
	}
	
	public function doLogout() {
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
}
?>