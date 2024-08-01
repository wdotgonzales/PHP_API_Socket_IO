<?php


header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require "../backend/Database.php";
require "../backend/InfoGateway.php";

// Handle preflight request (OPTIONS)
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $database = new Database();

    $info_gateway = new InfoGateway($database);


    $postRequestValues = (array) json_decode(file_get_contents('php://input'), true);

    $result = $info_gateway->postInfo(
        $postRequestValues['first_name'],
        $postRequestValues['last_name'],
        (int) $postRequestValues['age'],
        $postRequestValues['address']
    );

    if (!$result) {
        http_response_code(500);
        echo json_encode(['status' => '500', 'message' => 'Fail to create info']);
        exit;
    }

    http_response_code(201);
    echo json_encode(['status' => '201', 'message' => 'Created']);
    exit;
} else {
    // If the request method is not POST, set HTTP response code to 405 (Method Not Allowed) and indicate that only POST is allowed
    http_response_code(405);
    header("Allow: POST");
    exit;
}
