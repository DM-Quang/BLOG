<?php  
    include "config.php";
    include 'function/filemanager.php';
    include 'function/postmanager.php';
    include "includes/header.php"; 


    if (isset($_POST['submit'])) {
        checkPost($_POST, $_FILES, $errors, $conn);
    }

?>


<div class="container mb-5" >
    <?php if ($_SESSION['signed_in'] == false) : ?>
        <div class="mt-5 col-md-6 offset-md-3 text-center">
            <h2 class="display-5">Please Login to Post</h2>
            <p>Create an account or login to the website.</p>
            <button type="button" class="btn btn-block btn-outline-primary"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Create Account/Login</a></button>
        </div>
    <?php else: ?>
        <div class="mt-3 col-md-6 offset-md-3">
            <?php if(isset($errors)): ?>
                <div class="alert alert-danger">
                    <?php 
                        foreach ($errors as $error) {
                            echo $error . "<br>";
                        }
                    ?>
                </div>
            <?php endif; ?>
            <div class="text-center mt-3">
            <h1>Create A New Post!!!</h1>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-md-6 offset-md-3 form_bg">
                    <form action="create.php" method="POST" enctype="multipart/form-data">
                    
                    <label for="title">Post Title</label>
                    <input type="text" class="form-control" name="title" value="">

                    <label for="content">Post Content</label>
                    <textarea name="content" cols="100" rows="8" class="form-control"></textarea>

                    <input type="file" name="img" value="" class="mt-3 mb-3 form-control">

                    <button type="submit" name="submit" class="btn btn-outline-dark btn-block mb-2"><i class="fas fa-edit"></i> Create new Post</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
     
</div>

<?php  include "includes/footer.php"; ?>