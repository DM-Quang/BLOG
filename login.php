<?php  
    
    include "config.php";
    include "function/account.php";
    include "includes/header.php"; 
    
?>

    <div class="registrationForm">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" onclick="register()">Register</button>
            </div>
            <form id="login" class="input-group" action="login.php" method="POST">
                <input type="text" class="input-field" id="username-sign-in" name="name" placeholder="Username" value="<?php if (isset($_POST["name"])) echo htmlspecialchars($_POST["name"]);?>" required>
                <p class="error"> <?php if (isset($errors["signin_username"])) echo $errors["signin_username"] ?> </p>
                <input type="password" class="input-field" id="password-sign-in" name="password" placeholder="Password" required>
                <p class="error"> <?php if (isset($errors["signin_password"])) echo $errors["signin_password"] ?> </p>
                <button type="submit" class="submit-btn" id="sign-in" name="sign_in">Sign In</button>
            </form>
            <form id="register" class="input-group" action="login.php" method="POST">

                <input type="text" class="input-field" id="username-field" name="username" placeholder="Username" value="<?php if (isset($_POST["username"])) echo htmlspecialchars($_POST["username"]);?>" required>
                <p class="error"> <?php if (isset($errors["signup_username"])) echo $errors["signup_username"] ?> </p>

                <input type="email" class="input-field" id="email-field" name="email" placeholder="Email" value="<?php if (isset($_POST["email"])) echo htmlspecialchars($_POST["email"]);?>" required>
                <p class="error"> <?php if (isset($errors["signup_email"])) echo $errors["signup_email"] ?> </p>

                <input type="password" class="input-field" id="password-field" name="password1" placeholder="Password" required>
                <p class="error"> <?php if (isset($errors["signup_password"])) echo $errors["signup_password"] ?> </p>
                <input type="password" class="input-field" id="confirm-password-field" name="password2" placeholder="Confirm Password" required>

                <button type="submit" class="submit-btn" id="sign-up" name="sign_up" >Sign Up</button>
            </form>
        </div>
    </div>

<?php  include "includes/footer.php"; ?>