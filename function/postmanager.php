<?php 
    function checkPost ($post, $file, &$errors, $conn, $task = 0) {
        $title = $post['title'];
        $content = $post['content'];
        $img_url = validateFile($file, "img");
        // $update_img: 
        // true  : don't update img
        // false : update img
        $update_img = 1;
        if ($task == 0) {
            if (validateFile($file, "img")) {
                $missing = "There was a problem with your image upload!";
                $errors['post_img'] = $missing;
            }
    
            if ($content == "" || $title == "") {
                $missing = "Post title and content cannot be empty!";
                $errors["post_title"] = $missing;
            }
    
            if (!$img_url) {
                $missing = "There was a problem with your image upload!";
                $errors['post_file'] = $missing;
            }
        }

        if ($task == 1) {
            if ($content == "" || $title == "") {
                $missing = "Post title and content cannot be empty!";
                $errors["post_title"] = $missing;
            }
            if ($file['img']['name'] == "" ) {
                $update_img = 0;
            } else {
                if (validateFile($file, "img")) {
                    $missing = "There was a problem with your image upload!";
                    $errors['post_img'] = $missing;
                }
                if (!$img_url) {
                    $missing = "There was a problem with your image upload!";
                    $errors['post_file'] = $missing;
                }
            }

        }

        // CREATE POST
        if (empty($errors) && $task == 0) {
            createPost ($title, $content, $img_url, $conn);
        }
        // EDIT POST
        if (empty($errors) && $task == 1) {
            updatePost ($post['postID'], $title, $content, $img_url, $update_img, $conn);
            echo $update_img;
        }
    }

    function updatePost ($postID, $title, $content, $img_url, $update_img, $conn) {
        if ($update_img == 1) {
            $sql = "UPDATE posts SET post_title = '$title', post_body = '$content', post_img = '$img_url' WHERE ID = $postID";
            mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE posts SET post_title = '$title', post_body = '$content' WHERE ID = $postID";
            mysqli_query($conn, $sql);
        }

        redirectToPost($postID, "save=success");
    }

    function createPost ($title, $content, $img_url, $conn) {
        $sql = "INSERT INTO posts (post_title, post_body, post_author, post_img) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $title, $content, $_SESSION['user_id'], $img_url);
        $stmt->execute();

        if ($stmt->affected_rows == 1) {
            redirectToPost($stmt->insert_id, "create=success");
        }
    }

    function getPosts ($num_posts, $conn, $limit = 12) {
        $sql = "SELECT posts.ID, posts.post_title, posts.post_body, posts.post_author, posts.date_created, posts.post_img, users.user_name FROM posts JOIN users ON users.ID = posts.post_author ORDER BY posts.date_created DESC LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $num_posts);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results->fetch_all(MYSQLI_ASSOC);
    }

    function outputPosts($posts, $col = 3, $img = true, $teaserlen = 150, $readmore = true) {
        $output = "";
     
        foreach ($posts as $post) {
            if ($img == true) {
                if ($post['post_img']  == '') {
                    $the_img = "images/default.png";
                } else {
                    $the_img = $post['post_img'];
                }
                $post_img = "<img class='card-img-top mt-1' src='{$the_img}' style='max-width:100%; border-radius: 5%;
                border: 2px solid rgb(168 148 197); height: 25vh;'>";
            } else {
                $posting = "";
            }
            $body = substr($post['post_body'], 0, $teaserlen);
            $output.= "<div class='col-md-{$col} mt-4 mb-4' style='width: 18rem;'>
            <div class='card h-100'>
            {$post_img}
            <div class='card-body' style='background: none;' pd-2>
                <p class='card-title' style='height:30%;'>{$post['post_title']}</p>
                <em class='card-text' style='height:20%;'>Author: {$post['user_name']}</em>
                <a href='post.php?id={$post['ID']}' style='height:fit-content;' class='btn btn-primary mt-2'>Go To Post</a>
            </div>
            </div>
            </div>";
        }
        return $output;
      }



    function redirectToPost ($id, $get = false) {
        $location = "Location: post.php?id={$id}&{$get}";

        header($location);
        
    }
?>