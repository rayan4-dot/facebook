<?php
require_once '../../includes/bootstrap.php';
require_once '../../includes/Database.php';

header('Content-Type: application/json');

$db = (new Database())->connect();


try {
    
    $auth = new Auth();
    if (!$auth->isLoggedIn()) 
    throw new Exception('Unauthorized');
    
    $data = json_decode(file_get_contents('php://input'), true);
    $requestId = $data['request_id'] ?? null;

    $friendModel = new Friend($db);
    $friendModel->acceptRequest($requestId);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}