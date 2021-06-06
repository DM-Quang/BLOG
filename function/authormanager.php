<?php 
    
    include "function/account.php";
    

    $users = [];
    $users = getUsers($conn);

    function getUsers($conn) {
        $sql = "SELECT * FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results->fetch_all(MYSQLI_ASSOC);
    }

    function outputUsers($users) {
        $output = "";

        foreach ($users as $user) {
            $output .= "
                <tr>
                    <th scope='row'>{$user['ID']}</th>
                    <td>{$user['user_name']}</td>
                    <td>{$user['user_email']}</td>
                    <td>{$user['user_role']}</td>
                    <td> <a class='btn btn-primary' href='user.php?id={$user['ID']}'><i class='fas fa-edit'></i> Edit</a> </td>
                </tr>
            ";
        }
        return $output;
    }

    function checkAndUpdateUser($POST, &$errors, $conn) {
        $userID = $POST['ID'];
        $username = $POST['username'];
        $email = $POST['email'];
        $role_new = $POST['role_new'];
        $role_old = $POST['role_old'];
        $admin = $POST['admin'];

        // CHECK USERNAME LENGTH, USERNAME'S EXISTENCE.
        if (!minmaxChars($username, 5, 20)) {
            $missing = "Username must be between 5-20 characters long!";
            $errors['username'] = $missing;
        } elseif (checkForUser($username, $conn, 2, $userID) == 1) {
            $missing = "Username already take!";
            $errors["username"] = $missing;
        }

        // VALIDATE EMAIL.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $missing = "Invalid email!";
            $errors["email"] = $missing;
        }

        $check = false;

        if (empty($errors) && $admin == 0) {
            updateUser($userID, $username, $email, $role_new, $conn);
            $check = true;
        } elseif (empty($errors)) {
            updateUser($userID, $username, $email, $role_old, $conn);
            $check = true;
        }
        
        return $check;
    }

    function updateUser($userID, $username, $email, $role, $conn) {
        $sql = "UPDATE users SET user_name = '$username', user_email = '$email', user_role = '$role' WHERE ID = $userID";
        mysqli_query($conn, $sql);

        signInUser($username, $userID, $role);
        header("Location: author.php");
    }





?>