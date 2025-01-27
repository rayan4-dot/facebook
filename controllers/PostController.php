<?php
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../models/Post.php';
class PostController {
    public function createPost() {
        $auth = new Auth();
        if (!$auth->isLoggedIn()) {
            header("Location: login.php");
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize content
            $content = htmlspecialchars($_POST['content']);
    
            // Handle image upload
            $imagePath = $this->handleImageUpload();
    
            // Save post
            $post = new Post();
            if ($post->create($_SESSION['user_id'], $content, $imagePath)) {
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Error creating the post.";
            }
        }
    }

    public function updatePost() {
        $auth = new Auth();
        if (!$auth->isLoggedIn()) {
            header("Location: login.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
            $postId = $_POST['post_id'];
            $content = htmlspecialchars($_POST['content']);

            // Handle the image upload for edit
            $existingImage = (new Post())->getImagePath($postId); // Retrieve the current image
            $image = $this->editImageUpload($existingImage);

            $post = new Post();
            if ($post->update($postId, $content, $image)) {
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Error updating the post.";
            }
        }
    }

    private function handleImageUpload() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "assets/uploads/";
            $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;

            // Get image dimensions and validate the file
            $imageSize = getimagesize($_FILES['image']['tmp_name']);
            if ($imageSize === false) {
                return null; // Not a valid image
            }

            $imageWidth = $imageSize[0];
            $imageHeight = $imageSize[1];

            // Set maximum dimensions for resizing
            $maxWidth = 800;
            $maxHeight = 800;

            // Calculate the scaling ratio
            $scaleRatio = min($maxWidth / $imageWidth, $maxHeight / $imageHeight);

            // Resize only if the image is larger than the max dimensions
            if ($scaleRatio < 1) {
                $newWidth = floor($imageWidth * $scaleRatio);
                $newHeight = floor($imageHeight * $scaleRatio);

                // Create a new image resource with the resized dimensions
                $srcImage = imagecreatefromstring(file_get_contents($_FILES['image']['tmp_name']));
                $dstImage = imagecreatetruecolor($newWidth, $newHeight);

                // Maintain transparency for PNG and GIF
                if ($imageSize['mime'] === 'image/png' || $imageSize['mime'] === 'image/gif') {
                    imagealphablending($dstImage, false);
                    imagesavealpha($dstImage, true);
                }

                // Resample the image
                imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);

                // Save the resized image
                switch ($imageSize['mime']) {
                    case 'image/jpeg':
                        imagejpeg($dstImage, $targetFile, 85); // 85% quality for JPEG
                        break;
                    case 'image/png':
                        imagepng($dstImage, $targetFile);
                        break;
                    case 'image/gif':
                        imagegif($dstImage, $targetFile);
                        break;
                }

                // Clean up resources
                imagedestroy($srcImage);
                imagedestroy($dstImage);

                return $targetFile; // Return the resized image path
            }

            // If no resizing is needed, move the file as is
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
            return $targetFile;
        }

        return null; // No image uploaded
    }

    private function editImageUpload($existingImage = null) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "assets/uploads/";
            $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Delete the old image if it exists
                if ($existingImage && file_exists($existingImage)) {
                    unlink($existingImage);
                }
                return $targetFile;
            }
        }

        // Return the existing image if no new one was uploaded
        return $existingImage;
    }
}
?>
