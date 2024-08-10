<?php
//check cookie
if(isset($_COOKIE['UserEmail'])){
    $UserEmail = $_COOKIE['UserEmail'];
    $UserName = $_COOKIE['UserName'];
    $UserPosition = $_COOKIE['UserPosition'];
} else {
    //redirect to login page
    echo '<script>
            var confirmMsg = confirm("Your session has timed out. Please log in again.");
            if (confirmMsg) {
                window.location.href = "LoginAndRegister.php";
            }
        </script>';
    exit();
}

//check if form is submitted
if(isset($_POST['addTask'])){
    //connect to database
    include 'DataBaseConnection\DataBaseConnection.php';

    //get form data
    $taskName = $_POST['taskName'];
    $taskDescription = $_POST['taskDescription'];
    $taskDate = $_POST['taskDate'];
    $taskPriority = $_POST['taskPriority'];

    //validate date currecnt date or future date
    $currentDate = date("Y-m-d");
    if($taskDate < $currentDate){
        echo '<script>
                alert("Please select a future date.");
                window.location.href = "AddTask.php";
            </script>';
        exit();
    }

    //get taskId from database
    $sql = "SELECT MAX(taskId) AS taskId FROM task";

    $result = mysqli_query($connection, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $taskId = $row['taskId'] + 1;
        }
    } else {
        $taskId = 1;
    }

    //insert data into database
    $sql = "INSERT INTO task (TaskId, TaskName, TaskDescription, TaskPriority, DueDate, TaskStatus, UserEmail) VALUES ('$taskId', '$taskName', '$taskDescription', '$taskPriority', '$taskDate', 'PENDING', '$UserEmail')";

    $result = mysqli_query($connection, $sql);

    if($result){
        echo '<script>
                alert("Task added successfully.");
                window.location.href = "Dashboard.php";
            </script>';
    } else {
        echo '<script>
                alert("Failed to add task.");
                window.location.href = "AddTask.php";
            </script>';
    }

    //close connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
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
                            <a href="AddTask.php" class="active">
                                <span class="material-symbols-outlined">add_task</span>
                                <span class="title">Add Task</span>
                            </a>
                        </li>
                        <li>
                            <a href="CompleteTask.php">
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
                    <h2>Add Task</h2>
                </div>
                <div class="user">
                    <h2><?php echo $UserName; ?><br><span><?php echo $UserPosition; ?></span></h2>
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
                            <li><a href="LogOut.php" class="dropdown-item">
                                <span class="material-symbols-outlined">logout</span> 
                                Log Out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Add Task Form -->
            <div class="TaskForm">
                <form id="addtaskForm" method="post" action="#">
                    <table>
                        <tr>
                            <td><label for="taskName">Task Name</label><br>
                                <input type="text" id="taskName" name="taskName" required></td>
                        </tr>
                        <tr>
                            <td><label for="taskDescription">Task Description</label><br>
                                <textarea name="taskDescription" id="taskDescription" required></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="taskDate">Task Date</label><br>
                                <input type="date" id="taskDate" name="taskDate" required></td>
                        </tr>
                        <tr>
                            <td><label for="taskPriority">Task Priority</label><br>
                                <select name="taskPriority" id="taskPriority" required>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td><button type="submit" name="addTask">Save</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </main>
    </div>
    <script src="JavaScript/script.js"></script>
</body>

</html>
