<?php
include('../database/connect.php');



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="card p-2">
            <?php
            if (isset($_POST['submit_register'])) {
                $full_name = $_POST['full_name'];
                $username = $_POST['username'];
                $password_before = $_POST['password'];
                $password = password_hash($password_before, PASSWORD_DEFAULT);

                $error_message = array();
                if (empty($full_name) || empty($username) || empty($password_before)) {
                    array_push($error_message, "Semua field harus diisi");
                }

                if (count($error_message) > 0) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($error_message as $error) {
                        echo $error . "<br>";
                    }
                    echo "</div>";
                } else {
                    $sql = "INSERT INTO access_table (full_name, username, password) VALUES ('$full_name', '$username', '$password')";
                    $result = mysqli_query($conn, $sql);
                    if ($result == true) {
                        echo "<div class='alert alert-success'>Register berhasil</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Register gagal</div>";
                    }
                }
            }
            ?>
            <h2 class="fw-bold">Register</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="full_name">Nama Lengkap</label>
                    <input type="text" class="form-control" name="full_name">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" name="submit_register" value="Register">
                </div>
                <p>Already registered? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>

</html>