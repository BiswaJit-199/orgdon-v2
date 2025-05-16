<?php
require_once '../core/Model.php';
class User extends Model {
	public function register($email, $password, $fullName, $role) {
		try {
			$regState = $this->database->prepare("INSERT INTO users(full_name, email, password, role) VALUES (:fullname, :email, :hased_pass, :role)");
			$regState->execute(["fullname" => $fullName, "email" => $email, "hased_pass" => $password, "role" => $role]);
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function login(string $email, string $password) {
		try {
			$logState = $this->database->prepare("SELECT user_id, email, password, full_name, role, is_active, health_id FROM users WHERE email = :email LIMIT 1");
			$logState->execute(["email" => $email]);

			$log_user = $logState->fetch(PDO::FETCH_ASSOC);

			if (!$log_user) {
				return false;
			}

			if (password_verify($password, $log_user['password'])) {
				if ($log_user['is_active'] ?? 0) {
					unset($log_user['password']);
					unset($log_user['is_active']);
					return $log_user;
				}
				return false;
			}
		} catch (PDOException $log_e) {
			return false;
		}
	}

	public function updateProfile($health_data) {
		$sql = "INSERT INTO user_health 
            (user_id, blood_group, is_diabetic, is_cancer, other_notes, created_at, updated_at) 
            VALUES 
            (:user_id, :blood_group, :is_diabetic, :is_cancer, :other_notes, NOW(), NOW())";

        $stmt = $this->database->prepare($sql);

        try {
            $stmt->execute([
                ':user_id' => $health_data['user_id'],
                ':blood_group' => $health_data['blood_group'],
                ':is_diabetic' => $health_data['is_diabetic'],
                ':is_cancer' => $health_data['is_cancer'],
                ':other_notes' => $health_data['other_notes']
            ]);

			$health_id = $this->database->lastInsertId();
			$stmt_2 = $this->database->prepare("UPDATE users set health_id = :health_id where user_id = :user_id");
			$stmt_2->execute([
                ':health_id' => $health_id,
                ':user_id' => $health_data['user_id']
            ]);

            return $health_id;
        } catch (PDOException $e) {
            error_log('Health Save Error: ' . $e->getMessage());
            return false;
        }
	}

	public function updateHealthProfile($health_data) {
		if (empty($health_data['user_id'])) {
			return false;
		}

		$sql = "UPDATE user_health SET 
					blood_group = :blood_group,
					is_diabetic = :is_diabetic,
					is_cancer = :is_cancer,
					other_notes = :other_notes,
					updated_at = NOW()
				WHERE user_id = :user_id";

		$stmt = $this->database->prepare($sql);

		return $stmt->execute([
			':blood_group' => $health_data['blood_group'],
			':is_diabetic' => $health_data['is_diabetic'],
			':is_cancer' => $health_data['is_cancer'],
			':other_notes' => $health_data['other_notes'],
			':user_id' => $health_data['user_id']
		]);
	}

	public function updateFitStatus($userId, $status)
	{
		$stmt = $this->database->prepare("UPDATE user_health SET is_fit_for_donation = ?, updated_at = NOW() WHERE user_id = ?");
		return $stmt->execute([$status, $userId]);
	}



	public function checkEmailExists($email) {
        $stmt = $this->database->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
	}

	public function getUserData($userID) {
        $stmt = $this->database->prepare("SELECT COUNT(*) FROM users WHERE user_id = ?");
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>