<?php
require_once __DIR__ . '/../OOP/classes/Database.php';
require_once __DIR__ . '/../lib/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../lib/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../lib/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function clamp($value, $min, $max)
{
	return max($min, min($max, $value));
}

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

function SendEmail($to, $toName, $subject, $body, $altBody)
{
	$mail = new PHPMailer(true);

	try {
		//Server settings
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'websmtp.simply.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = EMAIL_NAME;                     //SMTP username
		$mail->Password   = EMAIL_PASS;                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
		$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom(EMAIL_NAME, 'Mailer');
		$mail->addAddress($to, $toName);     //Add a recipient

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = $altBody;

		$mail->send();
		return true;
	} catch (Exception $e) {
		return false;
	}
}
