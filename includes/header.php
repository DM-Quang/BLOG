
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1959031 - Do Minh Quang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-color">
        <div class="container">
            <a class="navbar-brand" href="index.php">ITEC Blog 2021</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create.php"><i class="fas fa-pen"></i> Create Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php"><i class="fas fa-user"></i> Author</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <?php  if ($_SESSION["signed_in"] == true): ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="user.php?id=<?php echo $_SESSION['user_id']; ?>"><i class="fa fa-user"></i> <?php  echo htmlspecialchars($_SESSION["user_name"] . " ");?>  |<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="logout.php"><i class="fa fa-door"></i>Logout<span class="sr-only">(current)</span></a>
                        </li>
                    <?php else: ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="login.php"><i class="fa fa-user"></i> Login / Create Account<span class="sr-only">(current)</span></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>  
