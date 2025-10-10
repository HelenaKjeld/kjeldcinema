<?php require_once("includes/connection.php");?>
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
		if (logged_in()) {
		redirect_to("index.php");
	}
 ?>

 <html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>

<?php
	// START FORM PROCESSING
    echo "hello there";
	if (isset($_POST['submit'])) { // Form has been submitted.
        echo "hello there";
		$email = trim($_POST['email']);
		$password = trim($_POST['pass']);
		
		try {
			// Prepare the SQL query using PDO
			$query = "SELECT UserID, Email, password FROM user WHERE Email = :Email LIMIT 1";
			$stmt = $connection->prepare($query);
			
			// Bind the Eamil parameter
			$stmt->bindParam(':Email', $email);
			$stmt->execute();
			
			// Fetch the result
			$found_user = $stmt->fetch(PDO::FETCH_ASSOC);
			 echo "hello there 2";
			if ($found_user) {
                echo "User found: " . htmlspecialchars($found_user['Email']) . "<br>"; // Debugging line
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
	} else { // Form has not been submitted.
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$message = "You are now logged out.";
		} 
	}

	// Display the message if set
	if (!empty($message)) {
		echo "<p>" . $message . "</p>";
	}
?>

<h2>Please login</h2>
<form action="" method="post">
Username:
<input type="text" name="email" maxlength="30" value="" />
Password:
<input type="password" name="pass" maxlength="30" value="" />
<input type="submit" name="submit" value="Login" />
</form>


</body>
</html>
<?php
if (isset($connection)){$connection = null;}
?>