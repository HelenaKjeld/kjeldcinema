<?php
require_once("includes/connection.php");
require_once("includes/functions.php");
if (isset($_POST['submit'])) {
    if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty($_POST['password'])) {
        header("Location: add_user.php?status=empty");
        exit();
    }

    $firstName = politi($_POST['firstName']);
    $lastName = politi($_POST['lastName']);
    $email = politi($_POST['email']);
    $iterations = ['cost' => 10];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $iterations);


    $query = dbCon()->prepare("INSERT INTO user (`Firstname`, `Lastname`, `Email`, `Password`) VALUES (?, ?, ?, ?)");
    $query->bindParam(1,$firstName);
    $query->bindParam(2,$lastName);
    $query->bindParam(3,$email);    
    $query->bindParam(4,$password);
    // Bind parameters in order: $firstName, $lastName, $email, $password
    $query->execute();
    header("Location: index.php?status=added");
} else {
    header("Location: index.php?status=0");
}
