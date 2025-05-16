<?php
require_once '../core/Model.php';

class Donation extends Model {
	public function hasAlreadyDonated($userId, $organType) {
        $stmt = $this->database->prepare("SELECT id FROM donations WHERE user_id = ? AND organ_type = ?");
        $stmt->execute([$userId, $organType]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

	public function getDonationStatus($userId)
    {
        $stmt = $this->database->prepare("SELECT * FROM donations WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return is_array($result) ? $result : [];
    }



	public function registerDonation($data) {
        $stmt = $this->database->prepare("
            INSERT INTO donations 
                (user_id, health_id, organ_type, availability, mobile_number, city, state, country, notes)
            VALUES 
                (:user_id, :health_id, :organ_type, :availability, :mobile_number, :city, :state, :country, :notes)
        ");
        return $stmt->execute($data);
    }

    public function getUsersPaginated($limit, $offset)
    {
        $stmt = $this->database->prepare("SELECT * FROM user_health ORDER BY user_id DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalUserCount()
    {
        $stmt = $this->database->query("SELECT COUNT(*) FROM user_health");
        return (int) $stmt->fetchColumn();
    }


	public function getHealthByUserId($userId) {
        $stmt = $this->database->prepare("SELECT * FROM user_health WHERE user_id = ? LIMIT 1");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

	public function updateHealth($data) {
        $stmt = $this->database->prepare("UPDATE user_health SET blood_group = ?, is_diabetic = ?, is_cancer = ?, is_fit_for_donation = ?, other_notes = ? WHERE user_id = ?");
        return $stmt->execute([
            $data['blood_group'],
            $data['is_diabetic'],
            $data['is_cancer'],
            $data['is_fit_for_donation'],
            $data['other_notes'],
            $data['user_id']
        ]);
    }

    public function getOrganDonationsPaginated($limit, $offset) {
        $sql = "SELECT 
                    u.user_id, u.full_name,
                    d.organ_type, d.availability, d.donation_status,
                    uh.blood_group, uh.is_fit_for_donation
                FROM donations AS d
                JOIN users AS u ON d.user_id = u.user_id
                JOIN user_health AS uh ON d.health_id = uh.id
                ORDER BY d.created_at DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllOrganDonations() {
        $stmt = $this->database->query("SELECT COUNT(*) FROM donations");
        return (int) $stmt->fetchColumn();
    }

    public function getFullDonationDetailByUserId($userId, $organ_type) {
        $sql = "SELECT 
                    d.id, u.full_name, d.organ_type, d.availability,
                    d.donation_status, d.mobile_number, uh.blood_group, uh.other_notes as notes,
                    d.created_at
                FROM donations d
                JOIN users u ON d.user_id = u.user_id
                JOIN user_health uh ON d.health_id = uh.id
                WHERE u.user_id = :user_id AND d.organ_type = :organ_type
                LIMIT 1";
        $stmt = $this->database->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'organ_type' => $organ_type]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateDonationStatus($donationId, $status) {
        $sql = "UPDATE donations SET donation_status = :status WHERE id = :id";
        $stmt = $this->database->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id' => $donationId
        ]);
    }
}

?>