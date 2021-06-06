<?php 
    include 'config.php';


    if (isset($_GET['id'])) {             
        $sql = 'DELETE FROM posts WHERE ID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        
        $sql = 'DELETE FROM comments WHERE comment_post = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();

        header("Location: index.php?delete=success");

    }
?>