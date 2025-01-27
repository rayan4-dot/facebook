<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');

try {
    $auth = new Auth();
    if (!$auth->isLoggedIn()) throw new Exception('Unauthorized');
    
    $data = json_decode(file_get_contents('php://input'), true);
    $comment = new Comment($data['post_id']);
    $comment->addComment($data['post_id'], $_SESSION['user_id'], $data['content']);
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}