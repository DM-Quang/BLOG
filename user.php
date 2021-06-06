<?php 
    include 'config.php';
    include 'function/authormanager.php';
    include 'includes/header.php';


    if (isset($_GET['id'])) {
        $sql = "SELECT * FROM users WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $results = $stmt->get_result();
        $errorsMsg;

        if ($_SESSION['user_id'] != $_GET['id'] && $_SESSION['user_role'] != 1) {
            $errorsMsg = "You don't have permission!";
        }

        $admin = 1;

        if ($_SESSION['user_role'] == 1) {
            $admin = 0;
        }

        if ($results->num_rows == 1) {
            $row = $results->fetch_assoc();
            $user_id = $row['ID'];
            $username = $row['user_name'];
            $email = $row['user_email'];
            $role = $row['user_role'];
        } else {
            $errorsMsg = "User not found!";
        }

    }

    if (isset($_POST['submit'])) {
        $check = checkAndUpdateUser($_POST, $errors_v2, $conn);
    }


?>

    <div class="jumbotron jumbotron-fluid text-black">
        <div class="container text-center">
            <h1 class="display-3">Experience Blog</h1>
            <p>We are happy to save your post !!</p>
        </div>    
    </div>

    <div class="container">
        <?php if (isset($errorsMsg)): ?>
            <div class="mt-5 mb-5 col-md-6 offset-md-3 text-center">
                <?php echo $errorsMsg; ?>
                <button type="button" class="btn btn-block btn-outline-primary"><a href="index.php"><i class="fas fa-home"></i> Back To Home</a></button>
            </div>
        <?php else: ?>
            <div class="text-center mt-3">
                <h1>User Infomation</h1>
            </div>

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <?php if (isset($errors_v2)): ?>
                        <div class="alert alert-danger">
                            <?php 
                                foreach ($errors_v2 as $error) {
                                    echo $error . "<br>";
                                }
                            ?>
                        </div>
                    <?php endif; ?>
                    <form action="user.php?id=<?php echo $user_id;?>" method="POST">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                        <label for="role">Role</label>
                        <input type="number" class="form-control" min="1" max="2" name="role_new" value="<?php echo $role; ?>">
                        
                        <input type="number" name="ID" value="<?php echo $user_id; ?>" hidden>
                        <input type="number" name="role_old" value="<?php echo $role; ?>" hidden>
                        <input type="number" name="admin" value="<?php echo $admin;?>" hidden>

                        <button type="submit" name="submit" class="btn btn-outline-dark btn-block mb-2 mt-2"><i class="fas fa-edit"></i> Save</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    
    </div>



<?php 
    include 'includes/footer.php';
?>