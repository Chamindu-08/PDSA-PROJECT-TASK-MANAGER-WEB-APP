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

//calculate task count
include 'DataBaseConnection\DataBaseConnection.php';

//get task count
$sql = "SELECT COUNT(TaskStatus) AS TaskCompleted FROM task WHERE TaskStatus = 'COMPLETED' AND UserEmail = '$UserEmail'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $taskCompleted = $row['TaskCompleted'];
    }
} else {
    $taskCompleted = 0;
}

//get task count
$sql = "SELECT COUNT(TaskStatus) AS TaskPending FROM task WHERE TaskStatus = 'PENDING' AND UserEmail = '$UserEmail'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $taskPending = $row['TaskPending'];
    }
} else {
    $taskPending = 0;
}

//get task count
$sql = "SELECT COUNT(TaskStatus) AS TaskOverdue FROM task WHERE TaskStatus = 'OVERDUE' AND UserEmail = '$UserEmail'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $taskOverdue = $row['TaskOverdue'];
    }
} else {
    $taskOverdue = 0;
}

//close connection
mysqli_close($connection);
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
                            <a href="DisplayTask.php" class="active">
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
                    <h2>Dashboard</h2>
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

            <div class="main">
                <div class="cards">
                    <div class="card">
                        <div class="cardInner">
                            <div class="cardTitle">
                                <h2>Task Completed</h2>
                            </div>
                            <div class="cardMain">
                                <h2><?php echo $taskCompleted; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="cardInner">
                            <div class="cardTitle">
                                <h2>Task Pending</h2>
                            </div>
                            <div class="cardMain">
                                <h2><?php echo $taskPending; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="cardInner">
                            <div class="cardTitle">
                                <h2>Task Overdue</h2>
                            </div>
                            <div class="cardMain">
                                <h2><?php echo $taskOverdue; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="projectCard">
                <div class="projectTop">
                    <h2>Task 01<br><span>Task name</span></h2>
                    <div class="projectDots">
                        <span class="material-symbols-outlined">
                            more_horiz
                        </span>
                    </div>
                </div>

                <div class="projectProgress">
                    <div class="process">
                        <h2>In Progress</h2>
                    </div>
                    <div class="priority">
                        <h2>High Priority</h2>
                    </div>
                </div>

                <div class="projectDiscription">
                    <h2>Task Description</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc
                        consectetur
                        ultricies. Donec auctor, nunc nec ultricies.</p>
                </div>

                <div class="date">
                    <h2>Due Date <br><span>2024-08-07</span></h2>
                </div>
            </div>

            <div class="projectCard">
                <div class="projectTop">
                    <h2>Task 02<br><span>Task name</span></h2>
                    <div class="projectDots">
                        <span class="material-symbols-outlined">
                            more_horiz
                        </span>
                    </div>
                </div>

                <div class="projectProgress">
                    <div class="process">
                        <h2>In Progress</h2>
                    </div>
                    <div class="priority">
                        <h2>Low Priority</h2>
                    </div>
                </div>

                <div class="projectDiscription">
                    <h2>Task Description</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc
                        consectetur
                        ultricies. Donec auctor, nunc nec ultricies.</p>
                </div>

                <div class="date">
                    <h2>Due Date <br><span>2024-08-07</span></h2>
                </div>
            </div>
        </main>
    </div>
    <script src="JavaScript/script.js"></script>
</body>

</html>
