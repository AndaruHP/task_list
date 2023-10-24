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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #080710;
        }

        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(#1845ad,
                    #23a2f6);
            left: -80px;
            top: -80px;
        }

        .shape:last-child {
            background: linear-gradient(to right,
                    #ff512f,
                    #f09819);
            right: -70px;
            bottom: -80px;
        }

form{
    height: 530px;
    width: 400px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}

        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 30px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            font-size: 16px;
            font-weight: 500;
        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            margin-top: 50px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        option {
            color: #080710;
        }

        p {
            margin-top: 15px;
            font-size: 14px;
        }
/* Reset some properties for smaller screens */
@media (max-width: 600px) {
    .background {
        width: 80%;
        height: auto;
        position: static;
        transform: none;
        left: 0;
        top: 0;
    }

    .background .shape {
        display12px;
    }

    input {
        height: 30px;
    }

    button {
        font-size: 14px;
        padding: 10px 0;
    }
    form {
        height: 630px;
    }
}

    </style>
</head>

<body>

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
                        <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
            <form action="" method="post">
                <h3>Register</h3>
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

</body>

</html>