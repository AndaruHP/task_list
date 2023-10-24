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
    <link rel="stylesheet" href="styles.css">|
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
            top: -140px;
        }

        .shape:last-child {
            background: linear-gradient(to right,
                    #ff512f,
                    #f09819);
            right: -70px;
            bottom: -150px;
        }

form{
    height: 670px;
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
    <div class="container">
        <div class="card p-3">
            <div class="row">
                <div class="col-md-10">

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