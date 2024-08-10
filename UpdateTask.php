<?php
// Check cookie
if (isset($_COOKIE['UserEmail'])) {
    $UserEmail = $_COOKIE['UserEmail'];
    $UserName = $_COOKIE['UserName'];
    $UserPosition = $_COOKIE['UserPosition'];
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Update</title>
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
                            <a href="CompleteTask.php">
                                <span class="material-symbols-outlined">task_alt</span>
                                <span class="title">Complete Task</span>
                            </a>
                        </li>
                        <li>
                            <a href="UpdateTask.php" class="active">
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

            <!-- Search Form -->
            <div class="TaskForm">
                <form action="">
                    <table>
                        <tr>
                            <td><label for="taskName">Task Name</label><br>
                                <select name="taskPriority" id="taskPriority" required>
                                    <option value="Task 01">Task 01</option>
                                    <option value="Task 02">Task 02</option>
                                    <option value="Task 03">Task 03</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td><button type="submit">Search</button></td>
                        </tr>
                    </table>
                </form>
            </div>

            <!-- Update Task Form -->
            <div class="TaskForm">
                <form action="">
                    <table>
                        <tr>
                            <h2>Task 01</h2>
                        </tr>
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
                            <td><button type="submit">Update</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </main>
    </div>
    <script src="JavaScript/script.js"></script>
</body>

</html>
