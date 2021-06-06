<?php  
    include "config.php";
    include "function/postmanager.php";
    include "includes/header.php"; 


?>

    <div class="jumbotron jumbotron-fluid text-black">
        <div class="container text-center">
            <h1 class="display-3">Experience Blog</h1>
            <p>We are happy to save your post !!</p>
        </div>    
    </div>
    <div class="container">
        <?php if (isset($_GET['signed_in'])): ?>
            <div class="alert alert-success" role="alert">
                You have Signed In successfully!
            </div>
        <?php elseif (isset($_GET['signed_out'])): ?>
            <div class="alert alert-warning" role="alert">            
                You have Signed Out successfully!
            </div>
        <?php elseif (isset($_GET['delete'])): ?>
            <div class="alert alert-success" role="alert">
                You have deleted post successfully!
            </div>
        <?php endif; ?>
        <h2>Recent Articles</h2>
        <hr>
        <div class="row align-item-center">
            <?php 
                $posts = getPosts (12, $conn);
                echo outputPosts($posts);
            ?>
            <hr>
        </div>
    </div>    


<?php  
    include "includes/footer.php"; 
?>