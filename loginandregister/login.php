<?php
session_start();
$_SESSION['status'] = "";
include('../database/connect.php');

if (isset($_POST['submit_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM access_table WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_login = $result->fetch_assoc();

    if (!$user_login) {
        $_SESSION['status'] = "<div class='alert alert-danger'>Username tidak ditemukan</div>";
    } else {
        if (password_verify($password, $user_login['password'])) {
            $_SESSION['status'] = "<div class='alert alert-success'>Login berhasil</div>";
            $_SESSION['user_id'] = $user_login['id'];
            header('location: ../index.php');
            exit;
        } else {
            $_SESSION['status'] = "<div class='alert alert-danger'>Password salah</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="card p-2">
            <h2 class="fw-bold">Login</h2>
            <?php
            echo $_SESSION['status'];
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" value="Login" name="submit_login">
                </div>
                <p>Not registered yet? <a href="register.php">Register</a></p>
            </form>
        </div>
    </div>
</body>

</html>