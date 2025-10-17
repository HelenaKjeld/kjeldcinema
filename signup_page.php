<?php
require_once("includes/connection.php");
if (isset($_POST['submit'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $iterations = ['cost' => 10];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $iterations);


    $query = dbCon()->prepare("INSERT INTO user (`Firstname`, `Lastname`, `Email`, `Password`) VALUES ('$firstName', '$lastName', '$email', '$password')");
    $query->execute();
    header("Location: index.php?status=added");
} else {
    header("Location: index.php?status=0");
}
