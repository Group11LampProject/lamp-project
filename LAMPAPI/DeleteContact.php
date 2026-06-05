<?php
require_once "db.php";

$inData = getRequestInfo();

$contactId = $inData["contactId"] ?? 0;
$userId = $inData["userId"] ?? 0;

$stmt = $conn->prepare("DELETE FROM Contacts WHERE ID=? AND UserID=?");
$stmt->bind_param("ii", $contactId, $userId);

if ($stmt->execute()) {
    sendResultInfoAsJson(["error" => ""]);
} else {
    sendResultInfoAsJson(["error" => "Could not delete contact."]);
}

$stmt->close();
$conn->close();
?>
