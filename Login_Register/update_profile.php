<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];


if(isset($_POST['update-profile'])){

    $update_name = mysqli_real_escape_string($con, $_POST['update-name']);
    $update_email = mysqli_real_escape_string($con, $_POST['update-email']);

    mysqli_query($con, "UPDATE users SET uname = '$update_name', email = '$update_email' WHERE id = $user_id") or die('query failed');

    $old_pass = $_POST['old-password'];
    $update_pass = $_POST['update-password'];
    $new_pass = $_POST['new-password'];
    $cnew_pass = $_POST['cnew-password'];

    if(!empty($update_pass) || !empty($new_pass) || !empty($cnew_pass)){
        if($update_pass != $old_pass){
            $message[] = 'Old password does not match!';
        }elseif($new_pass != $cnew_pass){
            $message[] = 'Confirm the new password!';
        }
        else{
            mysqli_query($con, "UPDATE users SET password = '$cnew_pass' WHERE id = $user_id")
            or die('query failed');

            $message[] = 'Password updated successfully!';
        }
    }
}   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div id="updateprofile">
        <?php
            $select = mysqli_query($con, "SELECT * FROM users WHERE id = '$user_id' ") or die('query failed');
            if (mysqli_num_rows($select) > 0) {
                $fetch = mysqli_fetch_assoc($select);
            } else {
                echo "No data found.";
            }
            if ($fetch['image'] == '') {
                echo '<img src="uploaded_img/default-avatar.png">';
            } else {
                echo '<img src="'. $fetch['image']. '">';
            }

        ?>
    
    
        <form action="" method="POST" enctype="multipart/form-data">
        <?php     
            if(isset($message)){
                foreach($message as $msg){
                    echo '<div class="message">'.$msg.'</div>';
                }
            }
            ?>
            <div class="flex">
                <div class="inputbox">
                    <span>Username: </span>
                    <input type="text" name="update-name" class="box"
                    value="<?php echo $fetch['uname']; ?>">

                    <span>E-mail: </span>
                    <input type="email" name="update-email" class="box"
                    value="<?php echo $fetch['email'];?>">

                    <span>Profile Picture: </span>
                    <input type="file" name="update-img" class="box" 
                    accept="image/jpg, image/png, image/jpeg">
                </div>

                <div class="inputbox">
                    <input type="hidden" name="old-password" value="<?php echo $fetch['password'];?>" class="box">
                    <span>Old Password: </span>
                    <input type="password" name="update-password" placeholder="Enter the previous password" class="box">
                    <span>New Password: </span>
                    <input type="password" name="new-password" placeholder="Enter a new password" class="box">
                    <span>Confirm Password: </span>
                    <input type="password" name="cnew-password" placeholder="Confirm the new password" class="box">
                </div>
            </div>
            <input type="submit" value="UPDATE" name="update-profile" class = "btn">
            <a href="home.php" class="delete-btn">Go to the home page</a>
    </form>
    </div>
</body>
</html>