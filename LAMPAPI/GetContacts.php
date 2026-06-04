<?php
require_once "db.php";

$inData = getRequestInfo();
$userId = $inData["userId"] ?? 0;

$stmt = $conn->prepare("SELECT ID AS id, FirstName AS firstName, LastName AS lastName, Relationship AS relationship, Email AS email, Phone AS phone, Address AS address, Notes AS notes FROM Contacts WHERE UserID=? ORDER BY FirstName, LastName");
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$contacts = [];

while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}

sendResultInfoAsJson(["contacts" => $contacts, "error" => ""]);

$stmt->close();
$conn->close();
?>
