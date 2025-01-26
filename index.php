<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/PostController.php';
require_once __DIR__ . '/controllers/FriendController.php';
require_once __DIR__ . '/controllers/ProfileController.php';

Session::start();

$requestUrl = $_GET['url'] ?? 'home';
$requestParts = explode('/', $requestUrl);

switch ($requestParts[0]) {
    case 'login':
        (new UserController())->login();
        break;
    case 'register':
        (new UserController())->register();
        break;
    case 'logout':
        (new Auth())->logout();
        header("Location: /login");
        break;
    case 'profile':
        (new ProfileController())->show($requestParts[1] ?? null);
        break;
    case 'friends':
        (new FriendController())->index();
        break;
    case 'api':
        require_once __DIR__ . '/api/' . ($requestParts[1] ?? '') . '.php';
        break;
    default:
        (new PostController())->index(); // Dashboard
        break;
}