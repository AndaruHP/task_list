<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: loginandregister/login.php');
    exit;
}
include('../database/connect.php');

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Get the task details
    $sql = "SELECT * FROM task_list WHERE user_id = {$_SESSION['user_id']} AND id = $task_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $taskStatus = $row['status'];
        $checklist = $row['checklist'];

        // Check if task is done and checklist is checked
        if ($taskStatus === 'Done' && $checklist === '1') {
            $sql = "DELETE FROM task_list WHERE id = $task_id";
            $result = mysqli_query($conn, $sql);
            header('location: ../index.php');
            exit;
        } else {
            // Task is not done or checklist is not checked, show a notification
            echo '<script>';
            echo 'if (confirm("Task belum selesai atau checklist belum diceklis, tidak dapat dihapus. Apakah Anda ingin kembali?"))';
            echo '{';
            echo '   window.location.href = "../index.php";';
            echo '}';
            echo 'else {';
            echo '   window.location.href = "../index.php";';
            echo '}';
            echo '</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9T@dneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="col-2">
            <a href="javascript:void(0);" class="btn btn-danger" onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</a>
        </div>
    </div>
</body>

</html>