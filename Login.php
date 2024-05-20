<?php 
    require 'connection.php';

    $error = array(); 

    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = $_POST['password']; 

        $select = "SELECT * FROM user_db WHERE email = '$email'";
        $result = mysqli_query($connection, $select);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            if(password_verify($password, $row['password'])){
                if($row['user_type'] == 'admin'){
                    $_SESSION['admin_name'] = $row['name'];
                    header('location:page_admin.php');
                } elseif($row['user_type'] == 'user'){
                    $_SESSION['user_name'] = $row['name'];
                    header('location:page_user.php');
                }
            } else {
                $error[] = 'Password salah!';
            }
        } else {
            $error[] = 'User tidak ditemukan!';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-contain">
        <form action="" method="post">
        <h3>Login Sekarang</h3>
        <?php 
            if (!empty($error)) { 
                foreach ($error as $err) {
                    echo '<span class="error-msg">' . $err . '</span>';
                }
            }
        ?>
        <input type="email" name="email" required placeholder="Masukkan alamat email">
        <input type="password" name="password" required placeholder="Masukkan kata sandi">
        <input type="submit" name="submit" value="Login" class="form-tombol">
        <p>Belum Punya Akun? <a href="form_register.php">Register Sekarang</a>!</p>
        </form>
    </div>
</body>
</html>
