<?php
// Check cookie
if (isset($_COOKIE['UserEmail'])) {
    $UserEmail = $_COOKIE['UserEmail'];
} else {
    // Redirect to login page
    echo '<script>
            var confirmMsg = confirm("Your session has timed out. Please log in again.");
            if (confirmMsg) {
                window.location.href = "LoginAndRegister.php";
            }
          </script>';
    exit();
}

// Initialize variables
$TaskName = $TaskDescription = $DueDate = $TaskPriority = '';
$TaskId = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['taskPriority'])) {
    // Database connection
    include 'DataBaseConnection/DataBaseConnection.php';

    if (!$connection) {
        echo "Connection failed";
    }

    $TaskId = $_POST['taskPriority'];

    // Query to retrieve task details
    $sql = "SELECT TaskName, TaskDescription, DueDate, TaskPriority FROM task WHERE TaskId = '$TaskId'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            $TaskName = $row['TaskName'];
            $TaskDescription = $row['TaskDescription'];
            $DueDate = $row['DueDate'];
            $TaskPriority = $row['TaskPriority'];
        }
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['taskId'])) {
    // Database connection
    include 'DataBaseConnection/DataBaseConnection.php';

    if (!$connection) {
        echo "Connection failed";
    }

    $TaskId = $_POST['taskId'];

    // Query to remove task
    $sql = "UPDATE task SET TaskStatus='COMPLETED' WHERE TaskId='$TaskId'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        echo "<script>alert('Task complete successfully!');</script>";
        // Clear the displayed task information
        $TaskName = $TaskDescription = $DueDate = $TaskPriority = '';
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Complete</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="container">
        <aside class="left">
            <header>
                <div class="logo">
                    <h2>TaskTinker</h2>
                </div>
                <nav>
                <ul>
                        <li>
                            <a href="Dashboard.php">
                                <span class="material-symbols-outlined">dashboard</span>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="DisplayTask.php">
                                <span class="material-symbols-outlined">task_alt</span>
                                <span class="title">Tasks</span>
                            </a>
                        <li>
                            <a href="AddTask.php">
                                <span class="material-symbols-outlined">add_task</span>
                                <span class="title">Add Task</span>
                            </a>
                        </li>
                        <li>
                            <a href="CompleteTask.php" class="active">
                                <span class="material-symbols-outlined">task_alt</span>
                                <span class="title">Complete Task</span>
                            </a>
                        </li>
                        <li>
                            <a href="UpdateTask.php">
                                <span class="material-symbols-outlined">update</span>
                                <span class="title">Update Task</span>
                            </a>
                        </li>
                        <li>
                            <a href="RemoveTask.php">
                                <span class="material-symbols-outlined">delete_history</span>
                                <span class="title">Remove Task</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="material-symbols-outlined">account_circle</span>
                                <span class="title">Profile</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="logout">
                    <button>
                        <span class="material-symbols-outlined">logout</span> Log Out
                    </button>
                </div>
            </header>
        </aside>
        <main class="right">
            <div class="top">
                <div class="searchBx">
                    <h2>Complete Task</h2>
                </div>
                <div class="user">
                    <h2>Chamindu<br><span>Undergraduate</span></h2>
                    <span class="material-symbols-outlined" id="accountIcon">account_circle</span>
                    <div class="dropdown">
                        <ul>
                            <li><a href="#" class="dropdown-item">
                                <span class="material-symbols-outlined">account_circle</span> 
                                Profile</a>
                            </li>
                            <li><a href="#" class="dropdown-item">
                                <span class="material-symbols-outlined">settings</span> 
                                Settings</a>
                            </li>
                            <li><a href="#" class="dropdown-item">
                                <span class="material-symbols-outlined">logout</span> 
                                Log Out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Search Form -->
            <div class="TaskForm">
                <form id="formTaskRemove" method="post" action="#">
                    <table>
                        <tr>
                            <td><label for="taskName">Task Name</label><br>
                                <?php
                                    // Database connection
                                    include 'DataBaseConnection/DataBaseConnection.php';

                                    if (!$connection) {
                                        echo "Connection failed";
                                    }

                                    // Query to retrieve tasks
                                    $sql = "SELECT TaskId, TaskName FROM task WHERE DueDate = CURRENT_DATE AND TaskStatus = 'PENDING' AND UserEmail = '$UserEmail'";
                                    $result = mysqli_query($connection, $sql);

                                    if ($result) {
                                        echo '<select name="taskPriority" id="taskPriority" required>';
                                                            
                                        // Display task options
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['TaskId'] . '">' . $row['TaskName'] . '</option>';
                                        }
                                                            
                                        echo '</select>';
                                                            
                                        mysqli_free_result($result);
                                    } else {
                                        echo "Error: " . mysqli_error($connection);
                                    }

                                    // Close the database connection
                                    mysqli_close($connection);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><button type="submit">Search</button></td>
                        </tr>
                    </table>
                </form>
            </div>

            <!-- Remove Task Form -->
            <div class="TaskForm">
                <form id="formTaskRemove" method="post" action="#">
                    <table>
                        <tr>
                            <h2><?php echo $TaskName; ?></h2>
                        </tr>
                        <tr>
                            <td><label for="taskName">Task Name</label><br>
                                <input type="text" id="taskName" name="taskName" value="<?php echo $TaskName; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td><label for="taskDescription">Task Description</label><br>
                                <textarea name="taskDescription" id="taskDescription" disabled><?php echo $TaskDescription; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="taskDate">Task Date</label><br>
                                <input type="date" id="taskDate" name="taskDate" value="<?php echo $DueDate; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td><label for="taskPriority">Task Priority</label><br>
                                <input type="text" id="taskPriority" name="taskPriority" value="<?php echo $TaskPriority; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="taskId" value="<?php echo $TaskId; ?>"></td>
                        </tr>
                        <tr>
                            <td><button type="submit" onclick="return confirm('Are you sure you want to complete this task?');">Complete</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </main>
    </div>
    <script src="JavaScript/script.js"></script>
</body>

</html>