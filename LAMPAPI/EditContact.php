<?php
require_once "db.php";

$inData = getRequestInfo();

$contactId = $inData["contactId"] ?? 0;
$userId = $inData["userId"] ?? 0;
$firstName = trim($inData["firstName"] ?? "");
$lastName = trim($inData["lastName"] ?? "");
$relationship = trim($inData["relationship"] ?? "");
$email = trim($inData["email"] ?? "");
$phone = trim($inData["phone"] ?? "");
$address = trim($inData["address"] ?? "");
$notes = trim($inData["notes"] ?? "");

$stmt = $conn->prepare("UPDATE Contacts SET FirstName=?, LastName=?, Relationship=?, Email=?, Phone=?, Address=?, Notes=? WHERE ID=? AND UserID=?");
$stmt->bind_param("sssssssii", $firstName, $lastName, $relationship, $email, $phone, $address, $notes, $contactId, $userId);

if ($stmt->execute()) {
    sendResultInfoAsJson(["error" => ""]);
} else {
    sendResultInfoAsJson(["error" => "Could not update contact."]);
}

$stmt->close();
$conn->close();
?>
