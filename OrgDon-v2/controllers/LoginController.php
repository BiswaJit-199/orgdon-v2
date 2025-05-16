<?php
require_once '../core/Controller.php';

class LoginController extends Controller {
	public function index() {
		if(is_logged()) {
			header('Location: /orgdon-v2/dashboard');
		}	
		$this->view('login', null, null, null, null, null);
	}

	public function login() {
		if ($_SERVER['REQUEST_METHOD'] === "POST") {
			$email = htmlspecialchars(trim($_POST['emailI'] ?? ''));
			$password = htmlspecialchars(trim($_POST['passwordI'] ?? ''));

			$logged_user = $this->model('User')->login($email, $password);

			if ($logged_user) {
				session_start();
				$_SESSION['log_cred'] = $logged_user;

				if ($logged_user['role'] == 'admin') {
					# code...
				} elseif ($logged_user['role'] == 'doctor') {
					header('Location: /orgdon-v2/dashboard');
					exit;
				} else {
					header('Location: /orgdon-v2/dashboard');
					exit;
				}
			} else {
				$this->view('login', ['error' => 'Invalid Email address or password.'], null, null, null, null);
			}
		}
	}
}
?>