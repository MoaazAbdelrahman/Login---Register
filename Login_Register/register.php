<?php

include 'config.php';

if(isset($_POST['submit'])){

    $UNAME = $_POST['uname'];
    $EMAIL = $_POST['email'];
    $PASS = $_POST['pass'];
    $CPASS = $_POST['cpass'];
    $IMAGE = $_FILES['img']['name'];
    $IMAGE_SIZE = $_FILES['img']['size'];
    $IMAGE_TMP_NAME = $_FILES['img']['tmp_name'];
    $IMAGE_FOLDER = 'uploaded_img/' . $IMAGE;

    $select = mysqli_query($con, "SELECT * FROM users WHERE email = '$EMAIL' 
    AND password = '$PASS' ") or die('query failed');

    if(mysqli_num_rows($select) > 0 ){
        $message[] = 'User already exists';
    }
    else{
        if($PASS != $CPASS){
            $message[] = 'Password did not match';
        }
        elseif($IMAGE_SIZE > 2000000 ){
            $message[] = 'Image is too large';
        }
        else{
            $upload = mysqli_query($con, "INSERT INTO users (uname, email, password, image) VALUES ('$UNAME', '$EMAIL', '$PASS', '$IMAGE_FOLDER') ") or die('query failed');

            if($upload){
                move_uploaded_file($IMAGE_TMP_NAME, $IMAGE_FOLDER);
                $message[]= 'Registered successfully!';
                header('location:login.php');
            }
            else{
                $message[]= 'Registeration Failed, please try again!';
            }
        }
    }
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>REGISTER NOW</h3>

            <?php 
            if(isset($message)){
                foreach($message as $msg){
                    echo '<div class="message">'.$msg.'</div>';
                }
            }
            ?>

            <input type="text" name="uname" placeholder="Enter a Username" class="box" required>
            <input type="email" name="email" placeholder="Enter your E-mail" class="box" required>
            <input type="password" name="pass" placeholder="Enter a Password" class="box" required>
            <input type="password" name="cpass" placeholder="Confirm Password" class="box" required>
            <input type="file" name="img" class="box" accept="image/jpg, image/png, image/jpeg">
            <input type="submit" name="submit" value="register" class="btn">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>