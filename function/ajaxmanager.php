<?php 
    include '../config.php';
    include '../classes/Comment.php';

    if (isset($_POST['comment'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];
        $comment_text = $_POST['comment'];
        $comment = new Comment($post_id, $conn);
        $comment->createComment($comment_text, $user_id);
    }
?>