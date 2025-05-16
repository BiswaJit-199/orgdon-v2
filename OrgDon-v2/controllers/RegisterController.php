<?php
require_once '../core/Controller.php';
class RegisterController extends Controller {
	public function index() {
		if(is_logged()) {
			header('Location: /orgdon-v2/dashboard');
		}
		$this->view('register', null, null, null, null, null);
	}

	public function register() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$email = htmlspecialchars(trim($_POST['emailI'] ?? ''));
			$password = htmlspecialchars(trim($_POST['passwordI'] ?? ''));
			$repPass = htmlspecialchars(trim($_POST['confirmPassI'] ?? ''));
			$fullName = htmlspecialchars(trim($_POST['fullname'] ?? ''));
			$role = htmlspecialchars(($_POST['role']));
			
			if (!empty($email)) {
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					if ($this->model('User')->checkEmailExists($email)) {
						// Handle error: username already exists
						$this->view('register', ['emailExist' => 'Email already exists.'], null, null, null, null);
						return;
					} else {
						if (!empty($password) && !empty($repPass)) {
							if ($password == $repPass) {
								if (!empty($fullName)) {
									$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
									if($this->model('User')->register($email, $hashedPassword, $fullName, $role)) {
										$this->view('register', ['success' => 'Registed successfully.'], null, null, null, null);
									} else {
										$this->view('register', ['error' => 'Registration failed. Please try again later.'], null, null, null, null);
                					return;
									}
								} else {
									$this->view('register', ['error' => 'Fullname is required.'], null, null, null, null, null);
                					return;
								}
							} else {
								$this->view('register', ['error' => 'Password and confirm password must be same.'], null, null, null, null, null);
                				return;
							}
						} else {
							$this->view('register', ['error' => 'Password and confirm password are required.'], null, null, null, null, null);
                			return;
						}
					}
				} else {
					$this->view('register', ['error' => 'Invalid Email address.'], null, null, null, null, null);
                	return;
				}
			} else {
				$this->view('register', ['error' => 'Email is required.'], null, null, null, null, null);
                return;
			}
		} else {
			header('Location: /register');
		}
	}
}
?>