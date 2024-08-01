<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require "../backend/Database.php";
require "../backend/InfoGateway.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $database = new Database();
    $info_gateway = new InfoGateway($database);

    $result = $info_gateway->getAllInfo();

    http_response_code(200);
    echo json_encode($result);
    exit;
} else {
    // If the request method is not POST, set HTTP response code to 405 (Method Not Allowed) and indicate that only POST is allowed
    http_response_code(405);
    header("Allow: GET");
    exit;
}
