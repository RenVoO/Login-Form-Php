<?php 
    require 'connection.php';

    $error = array(); 

    if(isset($_POST['submit'])){
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user_type = $_POST['user_type']; 

        $select = "SELECT * FROM user_db WHERE email = '$email'";
        $result = mysqli_query($connection, $select);

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'User sudah ada!'; 
        } else {
            $insert = "INSERT INTO user_db (name, email, password, user_type) VALUES ('$name', '$email', '$password', '$user_type')";
            mysqli_query($connection, $insert);
            header('location: Login.php');
            exit();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-contain">
        <form action="" method="post">
            <h3>Register Sekarang</h3>
            <?php 
                if (!empty($error)) { 
                    foreach ($error as $err) {
                        echo '<span class="error-msg">' . $err . '</span>';
                    }
                }
            ?>
            <input type="text" name="name" required placeholder="Masukkan nama"> 
            <input type="email" name="email" required placeholder="Masukkan email"> 
            <input type="password" name="password" required placeholder="Masukkan password"> 
            <select name="user_type"> 
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="submit" value="Register Sekarang" class="form-tombol">
            <p>sudah punya akun? <a href="form_login.php">Login Sekarang</a>!</p>
        </form>
    </div>
</body>
</html>
