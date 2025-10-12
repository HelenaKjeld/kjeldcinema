<?php
require_once("connection.php");



	function redirect_to($location) {
			header("Location: {$location}");
			exit;
	}

	function authenticate($email="", $password="")
	{
		try {
			// Prepare the SQL query using PDO
			$query = "SELECT UserID, Email, password FROM user WHERE Email = :Email LIMIT 1";
			$stmt = dbCon()->prepare($query);
			
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
?>