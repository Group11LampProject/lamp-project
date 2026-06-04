<?php
require_once "db.php";

$inData = getRequestInfo();

$userId = $inData["userId"] ?? 0;
$firstName = trim($inData["firstName"] ?? "");
$lastName = trim($inData["lastName"] ?? "");
$relationship = trim($inData["relationship"] ?? "");
$email = trim($inData["email"] ?? "");
$phone = trim($inData["phone"] ?? "");
$address = trim($inData["address"] ?? "");
$notes = trim($inData["notes"] ?? "");

$stmt = $conn->prepare("INSERT INTO Contacts (UserID, FirstName, LastName, Relationship, Email, Phone, Address, Notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssss", $userId, $firstName, $lastName, $relationship, $email, $phone, $address, $notes);

if ($stmt->execute()) {
    sendResultInfoAsJson(["error" => ""]);
} else {
    sendResultInfoAsJson(["error" => "Could not save contact."]);
}

$stmt->close();
$conn->close();
?>

