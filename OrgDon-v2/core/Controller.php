<?php
class Controller {
	public function model($model) {
		require_once '../models/' . $model . '.php';
		return new $model();
	}

	public function view($view, $flash = [], $data = [], $donations = [], $health, $paginatedData = []) {
		require_once '../views/' . $view . '.php';
	}
}

function is_logged() {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	return isset($_SESSION['log_cred']);
}

function get_role() {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	return $_SESSION['log_cred']['role'];
}
?>