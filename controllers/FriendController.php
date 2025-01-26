<?php
class FriendController {



    public function index() {
        $auth = new Auth();
        if (!$auth->isLoggedIn()) {
            header("Location: /login");
            exit;
        }

        // Get friend data
        $user_id = $_SESSION['user_id'];
        $friendModel = new Friend();
        
        $requests = $friendModel->getRequests($user_id);
        $friends = $friendModel->getFriends($user_id);

        include '../views/friends.php';
    }
    public function sendRequest() {
        $auth = new Auth();
        if (!$auth->isLoggedIn()) {
            header("Location: /login");
            exit;
        }
    
        if (isset($_POST['friend_id'])) {
            $friendModel = new Friend();  // Correct instantiation
            $friendModel->sendRequest(
                $_SESSION['user_id'], 
                $_POST['friend_id']
            );
        }
    }
    
    public function acceptRequest() {
        $auth = new Auth();
        if (!$auth->isLoggedIn()) {
            header("Location: /login");
            exit;
        }
    
        if (isset($_POST['request_id'])) {
            $friendModel = new Friend();  // Correct instantiation
            $friendModel->acceptRequest($_POST['request_id']);
        }
    }
}
?>