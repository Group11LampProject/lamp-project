<?php
require_once "db.php";

$inData = getRequestInfo();

$firstName = trim($inData["firstName"] ?? "");
$lastName = trim($inData["lastName"] ?? "");
$login = trim($inData["login"] ?? "");
$password = $inData["password"] ?? "";

if ($firstName === "" || $lastName === "" || $login === "" || $password === "") {
    sendResultInfoAsJson(["error" => "Please fill out all fields."]);
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstName, $lastName, $login, $hashedPassword);

if ($stmt->execute()) {
    sendResultInfoAsJson(["error" => ""]);
} else {
    sendResultInfoAsJson(["error" => "That email already has an account."]);
}

$stmt->close();
$conn->close();
?>
