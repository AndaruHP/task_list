<?php
session_start();
$_SESSION['status'] = "";
include('../database/connect.php');

if (isset($_POST['add_task'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date'];
    $status = "Not Started yet";
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO task_list (title, description, date_task, status, user_id, checklist) VALUES ('$title', '$description', '$date', '$status', '$user_id',0)";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('location: ../index.php');
        exit;
    } else {
        $_SESSION['status'] = "<div class='alert alert-danger'>Gagal menambahkan task</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="card p-3">
            <h2 class="fw-bold">Add New Task</h2>
            <?php
            echo $_SESSION['status'];
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="date">
                </div>
                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" value="Add" name="add_task">
                    <a href="../index.php" class="btn btn-danger mt-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>