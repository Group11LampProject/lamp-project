<?php
require_once "db.php";

$inData = getRequestInfo();

$login = $inData["login"];
$password = $inData["password"];

$stmt = $conn->prepare("SELECT ID, FirstName, LastName, Password FROM Users WHERE Login=?");
$stmt->bind_param("s", $login);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row["Password"])) {
        sendResultInfoAsJson([
            "id" => $row["ID"],
            "firstName" => $row["FirstName"],
            "lastName" => $row["LastName"],
            "error" => ""
        ]);
    } else {
        sendResultInfoAsJson(["error" => "Incorrect email or password."]);
    }
} else {
    sendResultInfoAsJson(["error" => "Incorrect email or password."]);
}

$stmt->close();
$conn->close();
?>
