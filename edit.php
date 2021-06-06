<?php 
    include 'config.php';
    include 'function/filemanager.php';
    include 'function/postmanager.php';
    include 'includes/header.php';

    if (isset($_GET['id'])) {
        $sql = "SELECT post_title, post_img, post_body, posts.date_created, users.user_name, users.ID AS author_id FROM posts JOIN users On users.ID = posts.post_author WHERE posts.ID = ?"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $results = $stmt->get_result();
        $errorsMsg;
        $check = true;
        if ($results->num_rows == 1) {
            $row = $results->fetch_assoc();
            $title = $row['post_title'];
            $content = $row['post_body'];
            $author_id = $row['author_id'];
            $author = $row['user_name'];
            $date = $row['date_created'];
            $img = $row['post_img'];
        } else {
            $errorsMsg = "Post not found!";
        }      
        if ($_SESSION['signed_in'] == false) {
            $errorsMsg = "You need to sign in to edit post!";
            $check = false;
        } elseif ($author_id != $_SESSION['user_id'] && $_SESSION['user_role'] != 1) {
            $errorsMsg = "Sorry, You aren't author!";
        }
    }

    if (isset($_POST['submit'])) {
        checkPost($_POST, $_FILES, $errors, $conn, 1);
    }

?>

    <?php if (isset($errorsMsg)): ?>
        <div class="mt-5 mb-5 col-md-6 offset-md-3 text-center">
            <div class="alert alert-danger" role="alert">
                <?php echo $errorsMsg; ?>
            </div>
            <?php if ($check == false): ?>
                <button type="button" class="btn btn-block btn-outline-primary"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Create Account/Sign in</a></button>
            <?php else: ?>
                <button type="button" class="btn btn-block btn-outline-primary"><a href="index.php"><i class="fas fa-sign-in-alt"></i> Back To Home</a></button>
            <?php endif; ?>
        </div>
    <?php else: ?>

    <div class="text-center mt-3">
        <h1>Edit Your Post!!!</h1>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?php if (isset($errors)): ?>
                <div class="alert alert-danger">
                    <?php 
                        foreach ($errors as $error) {
                            echo $error . "<br>";
                        }
                    ?>
                </div>
            <?php endif; ?>
            <form action="edit.php?id=<?php echo $_GET['id'];?>" method="POST" enctype="multipart/form-data">
                <img class="card-img-top mb-4" src="<?php echo $img; ?>" style="max-width:100%; border-radius: 5%;
                    border: 2px solid rgb(168 148 197); height: 20rem;">

                <label for="image">Upload new Image here</label>
                <input type="file" name="img" class="mt-3 mb-3 form-control">

                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">

                <label for="content">Post Content</label>
                <textarea name="content" cols="100" rows="8" class="form-control"><?php echo $content;?></textarea>

                <input type="hidden" name="postID" value="<?php echo $_GET['id']; ?>">

                <button type="submit" name="submit" class="btn btn-outline-dark btn-block mb-2 mt-2"><i class="fas fa-edit"></i> Save Post</button>
            </form>
        </div>
    </div>
    
    <?php endif; ?>

<?php 
    include 'includes/footer.php';
?>