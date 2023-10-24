<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: loginandregister/login.php');
    exit;
}
include('database/connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div class="container">
        <div class="card p-3">
            <div class="row">
                <div class="col-md-10">
                    <?php
                    $sql = "SELECT * FROM access_table WHERE id = " . $_SESSION['user_id'];
                    $result = mysqli_query($conn, $sql);
                    $user = mysqli_fetch_assoc($result);

                    echo "<h2 class='fw-bold'>Welcome, " . $user['username'] . "</h2>";
                    ?>
                </div>
                <div class="col-md-2">
                    <a href="loginandregister/logout.php" class="btn btn-primary">Logout</a>
                </div>
            </div>
            <div class="row">
                <div class="col-4">

                </div>
                <div class="col-4">
                </div>
                <div class="col-4">

                </div>
            </div>
            <div class="row">
                <div class="col-4">

                </div>
                <div class="row col-4">
                    <a href="task/insert_task.php" class="btn btn-primary">Add New Task</a>
                </div>
                <div class="col-4">

                </div>
            </div>
            <!-- ... -->
            <div class="row">
                <?php
                $statusOrder = array("Not Started yet", "On Progress", "Done");

                $sql = "SELECT * FROM task_list WHERE user_id = " . $_SESSION['user_id'] . " ORDER BY FIELD(status, '" . implode("', '", $statusOrder) . "')";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="card p-2 my-2">
                            <div class="row">
                                <div class="col-2">
                                    <h5 class="fw-bold"><?php echo $row['title']; ?></h5>
                                </div>
                                <div class="col-4">
                                    <p><?php echo $row['description']; ?></p>
                                </div>
                                <div class="col-1">
                                    <p><?php echo $row['date_task']; ?></p>
                                </div>
                                <div class="col-1">
                                    <form id="checkbox_form_<?php echo $row['id']; ?>" action="task/update_checkbox.php" method="post">
                                        <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                        <input type="checkbox" name="checkbox_state" <?php echo ($row['checklist'] === '1') ? 'checked' : ''; ?> class="form-check-input" onchange="submitCheckboxForm(this)">
                                    </form>
                                </div>

                                <div class="col-2">
                                    <form id="status_form_<?php echo $row['id']; ?>" action="task/update_status.php" method="post">
                                        <select id="status_<?php echo $row['id']; ?>" name="status" class="form-control" onchange="submitForm(this)">
                                            <option value="Not Started yet" <?php echo ($row['status'] === 'Not Started yet') ? 'selected' : ''; ?>>Not Started yet</option>
                                            <option value="On Progress" <?php echo ($row['status'] === 'On Progress') ? 'selected' : ''; ?>>On Progress</option>
                                            <option value="Done" <?php echo ($row['status'] === 'Done') ? 'selected' : ''; ?>>Done</option>
                                        </select>
                                        <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                    </form>
                                </div>
                                <div class="col-2">
                                    <a href="task/edit_task.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="task/delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <!-- ... -->

        </div>
    </div>
    <script>
        function submitForm(selectElement) {
            const form = selectElement.closest('form');
            form.submit();
        }
    </script>
    <script>
        function submitCheckboxForm(checkbox) {
            checkbox.closest('form').submit();
        }
    </script>

</body>

</html>