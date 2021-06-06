<?php 

    $errors = [];

    if (isset($_POST["sign_in"])) {
        checkSignIn($_POST, $errors, $conn);
    }
    elseif (isset($_POST["sign_up"])) {
        checkSignUp($_POST, $errors, $conn);
    }

    // CHECK SIGN_IN FORM FOR ERRORS.
    function checkSignIn($POST, &$errors, $conn) {
        $name = $POST['name'];
        $password = $POST['password'];

        // CHECK USERNAME'S EXISTENCE.
        if (checkForUser($name, $conn) != 1) {
            $missing = "Username not found!";
            $errors['signin_username'] = $missing;
        }
        else {
            // CHECK PASSWORD
            $user_row = getUserRow($name, $conn);
            if (!password_verify($password, $user_row['user_hash'])) {
                $missing = "Incorrect Password!";
                $errors['signin_password'] = $missing;
            }
        }

        // NO ERRORS -> SIGN IN SUCCESSFULLY.
        if (empty($errors)) {
            signInUser($user_row['user_name'], $user_row['ID'], $user_row['user_role']);
        }

    }

    // CHECK SIGN_UP FORM FOR ERRORS.
    function checkSignUp($POST, &$errors, $conn) {
        $username = $POST['username'];
        $email = $POST['email'];
        $password1 = $POST['password1'];
        $password2 = $POST['password2'];

        // CHECK USERNAME LENGTH, USERNAME'S EXISTENCE.
        if (!minmaxChars($username, 5, 20)) {
            $missing = "Username must be between 5-20 characters long!";
            $errors['signup_username'] = $missing;
        }
        elseif (checkForUser($username, $conn) == 1) {
            $missing = "Username already take!";
            $errors["signup_username"] = $missing;
        }

        // VALIDATE EMAIL.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $missing = "Invalid email!";
            $errors["signup_email"] = $missing;
        }

        // CHECK PASSWORD LENGTH AND MATCHING.
        if (!minmaxChars($password1, 5) || $password1 != $password2) {
            $missing = "Password is too short or does not match!";
            $errors["signup_password"] = $missing;
        }



        // NO ERRORS => INSERT USER TO DB AND SIGN IN.
        if (empty($errors)) {
            $user_id = signUpUser($conn, $username, $email, $password1);
            if ($user_id != 0) {
                signInUser($username, $user_id, 2);
            }
        }
        else {
            echo "<script> window.onload = function() {
                let x = document.getElementById('login');
                let y = document.getElementById('register');
                let z = document.getElementById('btn');
                x.style.left = '-400px';
                y.style.left = '50px';
                z.style.left = '110px';        
            } </script>";

        }

    
    }

    // QUERY THE DB TO SEE IF A USER EXISTS. RETURNS NUM_ROWS.
    // kind = 1 is check for sign up
    // kind = 2 is check for update user (it's fine when username doesn't change)
    function checkForUser ($username, $conn, $kind = 1, $user_id = 0) {
        if ($kind == 1) {
            $sql = "SELECT * FROM users WHERE user_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $results = $stmt->get_result();
            return $results->num_rows;
        } elseif ($kind == 2) {
            $sql = "SELECT * FROM users WHERE user_name = ? AND ID != ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $username, $user_id);
            $stmt->execute();
            $results = $stmt->get_result();
            return $results->num_rows;
        }

    }

    // FETCH A USER FROM THE DB BASED ON USERNAME.
    function getUserRow($username, $conn) {
        $sql = "SELECT * FROM users WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results->fetch_assoc();
    }

    // SIGN IN USER IN FUNCTION, SETS $_SESSION VALUES AND REDIRECTS TO HOME.
    function signInUser($user_name, $user_id, $user_role) {
        $_SESSION['signed_in'] = true;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_role'] = $user_role;
        header("Location: index.php?signed_in=success");
    }

    // CHECK STRING LENGTH.
    function minmaxChars($string, $min, $max = 1000) {
        if (strlen($string) < $min || strlen($string) > $max)
            return false;
        else return true;
    }

    // INSERT A NEW USER INTO THE DB.
    function signUpUser($conn, $user_name, $user_email, $user_password) {
        $user_hash = password_hash($user_password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (user_name, user_email, user_hash) VALUES (?, ?, ?)"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $user_name, $user_email, $user_hash);
        $stmt->execute();
        if ($stmt->affected_rows == 1) {
            return $stmt->insert_id;
        } else {
            return 0;
        }
    }

?>
