<?php
class FriendController {
    public function sendRequest() {
        $auth = new Auth();
        if (!$auth->isLoggedIn()) return;

        if (isset($_POST['friend_id'])) {
            $friend = new Friend($_SESSION['user_id']);
            $friend->sendRequest($_SESSION['user_id'], $_POST['friend_id']);
        }
    }

    public function acceptRequest() {
        if (isset($_POST['request_id'])) {
            $friend = new Friend($_SESSION['user_id']);
            $friend->acceptRequest($_POST['request_id']);
        }
    }
}
?>