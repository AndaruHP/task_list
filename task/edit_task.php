<?php
session_start();

$_SESSION['status'] = "";

include('../database/connect.php');
if (!isset($_SESSION['user_id'])) {
    header('location: ../loginandregister/login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM task_list WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['edit_task'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];

    $sql = "UPDATE task_list SET title = '$title', description = '$description', date_task = '$date' WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (empty($title) || empty($description) || empty($date)) {
        $_SESSION['status'] = "<div class='alert alert-danger'>Data tidak boleh kosong</div>";
    } else {
        if ($result) {
            header('location: ../index.php');
            exit;
        } else {
            $_SESSION['status'] = "<div class='alert alert-danger'>Gagal mengedit task</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="card p-3">
            <h2 class="fw-bold">Edit Task</h2>
            <?php
            echo $_SESSION['status'];
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" value="<?= $row['title'] ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="3"><?= $row['description'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="date" value="<?= $row['date_task'] ?>">
                </div>
                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" value="Edit" name="edit_task">
            </form>
        </div>
    </div>
</body>

</html>