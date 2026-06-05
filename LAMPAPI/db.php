<?php

$host = "localhost";
$user = "hub_api";
$pass = "password123";
$dbname = "hub";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error)
{
    die(json_encode(["error" => $conn->connect_error]));
}

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

function sendResultInfoAsJson($obj)
{
    header('Content-Type: application/json');
    echo json_encode($obj);
}

?>
