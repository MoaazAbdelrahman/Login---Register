<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

    $EMAIL = $_POST['email'];
    $PASS = $_POST['pass'];

    $select = mysqli_query($con, "SELECT * FROM users WHERE email = '$EMAIL' 
    AND password = '$PASS' ") or die('query failed');

    if(mysqli_num_rows($select) > 0 ){
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
    }
    else{
        $message[] = 'Incorrect E-mail or Password';
    }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>LOGIN NOW</h3>

            <?php 
            if(isset($message)){
                foreach($message as $msg){
                    echo '<div class="message">'.$msg.'</div>';
                }
            }
            ?>

            <input type="email" name="email" placeholder="Enter your E-mail" class="box" required>
            <input type="password" name="pass" placeholder="Enter a Password" class="box" required>
            <input type="submit" name="submit" value="login" class="btn">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>