<?php
include('../database/connect.php');

if (isset($_POST['task_id'])) {
    $taskId = $_POST['task_id'];
    $isChecked = isset($_POST['checkbox_state']) ? 1 : 0; // Convert to 1 if checked, 0 if unchecked

    $sql = "UPDATE task_list SET checklist = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $isChecked, $taskId);
    $stmt->execute();

    // Close the database connection
    $stmt->close();
    header('location: ../index.php');
}
