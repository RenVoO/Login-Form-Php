    <?php
    require 'connection.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM db_user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                header("Location: welcome.php");
                exit;
            } else {
                echo "Kata sandi salah.";
            }
        } else {
            echo "Username tidak ditemukan.";
        }

        $stmt->close();
    }


    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h2>Formulir Login</h2>
        <form action="login.php" method="post">
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
    </body>
    </html>
