<?php
require_once __DIR__ . '/../OOP/classes/Database.php';

function politi($value)
{
	return htmlspecialchars(trim($value));
}

function redirect_to($location)
{
	header("Location: {$location}");
	exit;
}

function authenticate($email = "", $password = "")
{
	try {
		// Prepare the SQL query using PDO
		$query = "SELECT UserID, Email, password FROM user WHERE Email = :Email LIMIT 1";

		$database = Database::getInstance();

		$stmt =  $database->getConnection()->prepare($query);

		// Bind the Eamil parameter
		$stmt->bindParam(':Email', $email);
		$stmt->execute();

		// Fetch the result
		$found_user = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($found_user) {
			// Check if the password is correct
			if (password_verify($password, $found_user['password'])) {
				// Email/password authenticated
				$_SESSION['user_id'] = $found_user['UserID'];
				$_SESSION['user'] = $found_user['Email'];
				redirect_to("index.php");
			} else {
				// Password is incorrect
				$message = "Email/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
			}
		} else {
			// No user found
			$message = "Email/password combination incorrect.<br />
				Please make sure your caps lock key is off and try again.";
		}
	} catch (PDOException $e) {
		die("Database query failed: " . $e->getMessage());
	}
}

function guidv4($data = null)
{
	// Generate 16 bytes (128 bits) of random data or use the data passed into the function.
	$data = $data ?? random_bytes(16);
	assert(strlen($data) == 16);

	// Set version to 0100
	$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
	// Set bits 6-7 to 10
	$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

	// Output the 36 character UUID.
	return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


function formatShowDateTime($date, $time)
{
	$showDate = new DateTime($date . ' ' . $time);
	$today = new DateTime();
	$tomorrow = (clone $today)->modify('+1 day');

	if ($showDate->format('Y-m-d') === $today->format('Y-m-d')) {
		$prefix = 'today';
	} elseif ($showDate->format('Y-m-d') === $tomorrow->format('Y-m-d')) {
		$prefix = 'tomorrow';
	} else {
		$prefix = $showDate->format('D d/m');
	}

	return $prefix . ' ' . $showDate->format('H:i');
}
