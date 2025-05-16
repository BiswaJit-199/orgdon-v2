<?php
require_once '../core/Controller.php';
class DashboardController extends Controller {
	public function roleBasedIndex() {
		if(!is_logged()) {
			header('Location: /orgdon-v2/auth/login');
		}
		
		$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
    	$limit = 5;
    	$offset = ($page - 1) * $limit;

		$allUsers = $this->model("Donation")->getUsersPaginated($limit, $offset);
		$totalUsers = $this->model("Donation")->getTotalUserCount();
		$totalPages = ceil($totalUsers / $limit);

		$this->view('dashboard', null, $data = [$this->getUserData($_SESSION['log_cred']['user_id'])], $donations = $this->model("Donation")->getDonationStatus($_SESSION['log_cred']['user_id']), $health = [$this->model("Donation")->getHealthByUserId($_SESSION['log_cred']['user_id'])], [$allUsers, $totalUsers, $totalPages]);
	}
	
	public function completeProfile() {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		
		// Check if user is logged in
        if (!isset($_SESSION['log_cred']['user_id'])) {
            header('Location: /orgdon-v2/logout');
            exit;
        }

        // Validate incoming POST data
        $blood_group = trim($_POST['blood_group'] ?? '');
        $is_diabetic = isset($_POST['is_diabetic']) ? (int)$_POST['is_diabetic'] : null;
        $is_cancer = isset($_POST['is_cancer']) ? (int)$_POST['is_cancer'] : null;
        $other_notes = trim($_POST['other_notes'] ?? '');

        // Basic Validation
        if (empty($blood_group) || !in_array($blood_group, ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-', 'rhNull']) || 
            ($is_diabetic !== 0 && $is_diabetic !== 1) || 
            ($is_cancer !== 0 && $is_cancer !== 1)) {
            $_SESSION['flash'] = ['error' => 'Invalid form submission.'];
            header('Location: /orgdon-v2/dashboard');
            exit;
        }

		$healthId = $this->model('User')->updateProfile([
            'user_id' => $_SESSION['log_cred']['user_id'],
            'blood_group' => $blood_group,
            'is_diabetic' => $is_diabetic,
            'is_cancer' => $is_cancer,
            'other_notes' => $other_notes
        ]);

        if ($healthId) {
            // Update session
            $_SESSION['log_cred']['health_id'] = $healthId;

            $_SESSION['flash'] = ['success' => 'Health profile completed successfully!'];
            header('Location: /orgdon-v2/dashboard');
            exit;
        } else {
            $_SESSION['flash'] = ['error' => 'Something went wrong. Please try again.'];
            header('Location: /orgdon-v2/dashboard');
            exit;
        }
	}

	public function registerDonor() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			$userId = $_SESSION['log_cred']['user_id'] ?? null;
			$healthId = $_SESSION['log_cred']['health_id'] ?? null;
			
			$organType = $_POST['organ_type'] ?? '';
			$availability = $_POST['availability'] ?? '';
			$mobile = $_POST['mobile_number'] ?? '';
			$city = $_POST['city'] ?? '';
			$state = $_POST['state'] ?? '';
			$country = $_POST['country'] ?? '';
			$notes = $_POST['notes'] ?? '';
			if (!$userId || !$organType || !$mobile || !preg_match('/^[0-9]{10}$/', $mobile)) {
				$_SESSION['flash']['error'] = "Invalid input data.";
				header("Location: /orgdon-v2/dashboard");
				exit;
			}
			
			if ($this->model("Donation")->hasAlreadyDonated($userId, $organType)) {
				$_SESSION['flash']['error'] = "You've already registered to donate this organ.";
				header("Location: /orgdon-v2/dashboard");
				exit;
			}
			
			$data = [
				'user_id' => $userId,
				'health_id' => $healthId,
				'organ_type' => $organType,
				'availability' => $availability,
				'mobile_number' => $mobile,
				'city' => $city,
				'state' => $state,
				'country' => $country,
				'notes' => $notes
			];
			
			if ($this->model("Donation")->registerDonation($data)) {
				$_SESSION['flash']['success'] = "Donor registered successfully.";
			} else {
				$_SESSION['flash']['error'] = "Registration failed. Please try again.";
			}
			
			header("Location: /orgdon-v2/dashboard");
			exit;
		}		
	}

	public function updateHealth() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}

			$userId = $_SESSION['log_cred']['user_id'] ?? null;
			$bloodGroup = $_POST['blood_group'] ?? '';
            $isDiabetic = $_POST['is_diabetic'] ?? '';
            $isCancer = $_POST['is_cancer'] ?? '';
            $otherNotes = $_POST['other_notes'] ?? '';
			
			if (!$userId || !$bloodGroup) {
                // Basic validation failed
                $_SESSION['flash']['error'] = "Missing required Data.";
				header("Location: /orgdon-v2/dashboard");
				exit;
            }
			
			$data = [
				'user_id' => $userId,
                'blood_group' => $bloodGroup,
                'is_diabetic' => $isDiabetic,
                'is_cancer' => $isCancer,
                'other_notes' => $otherNotes
			];
			
			if ($this->model("User")->updateHealthProfile($data)) {
				$_SESSION['flash']['success'] = "Health Profile updated registered successfully.";
			} else {
				$_SESSION['flash']['error'] = "Health Profile update failed. Please try again.";
			}
			
			header("Location: /orgdon-v2/dashboard");
			exit;
		}
	}

	public function updateFitStatus()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$userId = $_POST['user_id'] ?? null;
			$fitStatus = $_POST['is_fit_for_donation'] ?? null;

			if (!$userId || $fitStatus === null) {
				$_SESSION['flash']['error'] = "Invalid update request.";
				header('Location: /orgdon-v2/dashboard');
				exit;
			}

			if ($this->model("User")->updateFitStatus($userId, $fitStatus)) {
				$_SESSION['flash']['success'] = "Updated successfully.";
			} else {
				$_SESSION['flash']['error'] = "Failed to update. Please try again.";
			}

			header("Location: /orgdon-v2/dashboard");
			exit;
		}
	}

	public function updateAvailability() {

	}


	public function getUserData() {
		$customerData = $this->model('User')->getUserData($_SESSION['log_cred']['user_id']);
	}



	public function logout() {
		// Start session if not started
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
	
		// Clear all session variables
		$_SESSION = [];
	
		// Destroy the session cookie (important for security)
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(), 
				'', 
				time() - 42000,
				$params["path"], 
				$params["domain"], 
				$params["secure"], 
				$params["httponly"]
			);
		}
	
		// Finally destroy the session
		session_destroy();
	
		// Redirect to login page or home
		header('Location: /orgdon-v2/auth/login'); 
		exit;
	}
}
?>