<?php
class PostController {
    public function createPost() {
        $auth = new Auth();
        if (!$auth->isLoggedIn()) {
            header("Location: login.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = htmlspecialchars($_POST['content']);
            $image = $this->handleImageUpload();
            
            $post = new Post();
            if ($post->create($_SESSION['user_id'], $content, $image)) {
                header("Location: index.php");
                exit;
            }
        }
    }

    private function handleImageUpload() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "assets/uploads/";
            $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                return $targetFile;
            }
        }
        return null;
    }
}
?>