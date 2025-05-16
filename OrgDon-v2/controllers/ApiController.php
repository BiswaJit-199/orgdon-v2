<?php
require_once '../core/Controller.php';
class ApiController extends Controller {
	public function organs() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $records = $this->model("Donation")->getOrganDonationsPaginated($limit, $offset);
        $total = $this->model("Donation")->countAllOrganDonations();

        header('Content-Type: application/json');
        echo json_encode([
            'page' => $page,
            'totalPages' => ceil($total / $limit),
            'records' => $records
        ]);
    }

    public function organDetails() {
        $userId = $_GET['user_id'] ?? null;
		$organ_type = $_GET['organ_type'] ?? null;
        if (!$userId) {
            http_response_code(400);
            echo json_encode(['error' => 'User ID is required']);
            return;
        }

		if (!$organ_type) {
            http_response_code(400);
            echo json_encode(['error' => 'User ID is required']);
            return;
        }

        $details = $this->model("Donation")->getFullDonationDetailByUserId($userId, $organ_type);

        header('Content-Type: application/json');
        echo json_encode($details);
    }

    public function updateDonationStatus() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $donationId = $data['donation_id'] ?? null;
        $newStatus = $data['donation_status'] ?? null;
    
        if (!$donationId || !in_array($newStatus, ['Pending', 'Approved', 'Rejected'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid input']);
            return;
        }
        
        $updated = $this->model("donation")->updateDonationStatus($donationId, $newStatus);
    
        header('Content-Type: application/json');
        echo json_encode([
            'message' => $updated ? 'Donation status updated successfully.' : 'Failed to update donation status.'
        ]);
    }
    
}
?>