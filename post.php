<?php 
    include_once 'config.php';
    include 'classes/Comment.php';
    include 'includes/header.php';

    if (isset($_GET['id'])) {
        $sql = "SELECT post_title, post_img, post_body, posts.date_created, users.user_name, users.ID AS author_id FROM posts JOIN users On users.ID = posts.post_author WHERE posts.ID = ?"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $results = $stmt->get_result();
        $errorsMsg;

        if ($results->num_rows == 1) {
            $row = $results->fetch_assoc();
            $post_id = $_GET['id'];
            $title = $row['post_title'];
            $content = $row['post_body'];
            $author_id = $row['author_id'];
            $author = $row['user_name'];
            $date = $row['date_created'];
            $img = $row['post_img'];
        } else {
            $errorsMsg = "Post not found!";
        }

        $comments = new Comment($_GET['id'], $conn);
        $comments->getComments();

        if (isset($_GET['delete'])) {
            if ($author_id != $_SESSION['user_id'] && $_SESSION['user_role'] != 1) {
                $errorsMsg = "You can't delete this post because you're not author or admin";
            } else {                
                header("Location: deletePost.php?id={$post_id}");
            }
        }
    }


?>

    <div class="jumbotron"
    <?php if (isset($img) && $img != ''): ?>
        style='background:url("<?php echo $img; ?>");'
    <?php endif;?>>
        <div class="container text-white">
            <?php if (isset($title)): ?>
                <h1 class="display-3">
                    <?php echo htmlspecialchars(($title)); ?>
                </h1>
                <p class="lead">
                    <?php echo htmlspecialchars(($date)); ?>
                </p>
                <p class="lead">
                    <a href="user.php?id= <?php echo htmlspecialchars($author_id); ?>">
                    <?php echo htmlspecialchars(($author)); ?>
                    </a>
                </p>
                <a href="edit.php?id=<?php echo $post_id;?>" class="btn btn-outline-primary">Edit Post</a>
                <a href="post.php?id=<?php echo $post_id;?>&delete=yes" class="btn btn-outline-danger">Delete Post</a>
            <?php else: ?>
                <h1 class="display-3">
                    <?php echo $errorsMsg; ?>
                </h1>
            <?php endif; ?>
            <?php if (isset($errorsMsg)): ?>
                <div class="alert alert-warning mt-3" role="alert">            
                    <?php echo $errorsMsg; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <?php if (isset($_GET['create'])): ?>
            <div class="alert alert-success" role="alert">
                Your post was successfully created!
            </div>
        <?php elseif (isset($_GET['save'])): ?>
            <div class="alert alert-success" role="alert">
                Your post was successfully saved!
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="text-center" style="width: 100%;">
                <h3>Content</h3>
            </div>
            <p>
                <?php if (isset($content)): ?>
                    <?php echo htmlspecialchars($content); ?>
                <?php endif; ?>
            </p>
        </div>
        
        <!-- comment part -->
        <div class="container">
            <hr>
            <h2 class="text-center display-4 mt-3 mb-3">Comments</h2>
            <hr>
            <div class="row comments">
                <div class="col-md-6 offset-md-3 form">
                    <?php if ($_SESSION['signed_in']): ?>
                        <form class="comment-form" method="POST" action="function/ajaxmanager.php?comment=true&<?php echo htmlspecialchars($_SERVER['QUERY_STRING']); ?>">
                            <textarea name="comment-text" cols="80" rows="4"></textarea>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_SERVER['QUERY_STRING']); ?>">                          
                            <button type="submit" name="comment-submit" class="btn btn-outline-success mt-2"><i class="far fa-comment"></i> Add Comment</button>                       
                        </form>
                    <?php else: ?>
                        <h3>Please Login To Comment!</h3>
                        <a href="login.php"><button type="button" class="btn btn-primary btn-lg">LOGIN</button></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="comments_before row">
                <?php $comments->outputComments(); ?>
            </div>
        </div>
    </div>

<?php 
    include 'includes/footer.php';
?>