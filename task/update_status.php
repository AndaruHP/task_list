<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: ../loginandregister/login.php');
    exit;
}

include('../database/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    // Pastikan $task_id adalah angka bulat (misalnya: pencegahan SQL injection)
    if (filter_var($task_id, FILTER_VALIDATE_INT)) {
        // Update status task di database
        $sql = "UPDATE task_list SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $status, $task_id);
        
        if ($stmt->execute()) {
            $_SESSION['status'] = "<div class='alert alert-success'>Status task berhasil diperbarui</div>";
        } else {
            $_SESSION['status'] = "<div class='alert alert-danger'>Gagal memperbarui status task</div>";
        }
        
        header('location: ../index.php');
        exit;
    }
} else {
    $_SESSION['status'] = "<div class='alert alert-danger'>Permintaan tidak valid</div>";
    header('location: ../index.php');
    exit;
}
