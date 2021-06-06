<?php 
    include "config.php";
    include "function/authormanager.php";
    include "includes/header.php";
?>

    <div class="jumbotron jumbotron-fluid text-black">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="display-3">Experience Blog</h1>
                    <p>We are happy to save your post !!</p>
                </div>
                <div class="col-md-6 text-left">
                    <h3>Role = 1</h3>
                    <p>You can change all information below of any user and all post.</p>
                    <h3>Role = 2</h3>
                    <p>You can only change username and email address and your post.</p>
                    <h5>Account admin</h5>
                    <p>Username: admin2</p>
                    <p>Password: admin2</p>
                </div>
            </div>
        </div>    
    </div>

    <div class="container">
        <?php if ($_SESSION['signed_in'] == false) : ?>
            <div class="mt-5 col-md-6 offset-md-3 text-center">
                <h2 class="display-5">Please Login to Post</h2>
                <p>Create an account or login to the website.</p>
                <button type="button" class="btn btn-block btn-outline-primary"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Create Account/Login</a></button>
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo outputUsers($users); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>



<?php 
    include "includes/footer.php";
?>