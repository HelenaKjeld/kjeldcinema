<?php
session_start();



function confirm_logged_in()
{
	if (!is_logged_in()) {
		redirect_to("index.php");
	}
}

function is_logged_in(): bool
{
	return isset($_SESSION['user_id']);
}

function is_admin(): bool
{
	return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function require_login(): void
{
	if (!is_logged_in()) {
		header("Location: ../auth/login.php"); // adjust path to your login page
		exit();
	}
}

function require_admin(): void
{
	if (!is_logged_in() || !is_admin()) {
		// Not logged in or not an admin
		header("Location: ../index.php");      // send them to homepage or profile
		exit();
	}
}
