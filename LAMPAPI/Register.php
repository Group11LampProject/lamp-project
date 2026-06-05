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

$check = $conn->prepare("SELECT ID FROM Users WHERE Login = ?");
$check->bind_param("s", $login);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    sendResultInfoAsJson(["error" => "That email already has an account."]);
    $check->close();
    $conn->close();
    exit();
}

$check->close();

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstName, $lastName, $login, $hashedPassword);

if ($stmt->execute()) {
    sendResultInfoAsJson(["error" => ""]);
} else {
    sendResultInfoAsJson(["error" => "Something went wrong. Please try again."]);
}

$stmt->close();
$conn->close();
?>
