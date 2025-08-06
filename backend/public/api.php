<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$path = $_GET['REQUEST_URI'] ?? $_SERVER['REQUEST_URI'] ?? '';
$path = parse_url($path, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if (isset($_GET['debug'])) {
    echo json_encode(['debug_path' => $path, 'full_uri' => $_SERVER['REQUEST_URI'] ?? 'not_set']);
    exit;
}

require_once __DIR__ . '/../routes/api.php';

$response = routeRequest($path);
echo json_encode($response); 