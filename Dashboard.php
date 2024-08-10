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

class Node {
    public $TaskName;
    public $TaskStatus;
    public $TaskPriority;
    public $Next;
}

class LinkedList {
    public $Head;

    public function __construct() {
        $this->Head = null;
    }

    public function Add($taskName, $taskStatus, $taskPriority) {
        $newNode = new Node();
        $newNode->TaskName = $taskName;
        $newNode->TaskStatus = $taskStatus;
        $newNode->TaskPriority = $taskPriority;
        $newNode->Next = null;

        if($this->Head == null) {
            $this->Head = $newNode;
        } else {
            $last = $this->Head;
            while($last->Next != null) {
                $last = $last->Next;
            }
            $last->Next = $newNode;
        }
    }

    public function Display() {
        $current = $this->Head;
        while($current != null) {
            //display task
            //check task status
            if($current->TaskStatus == 'COMPLETED') {
                $taskIcon = '<span class="tasksIcon done">
                                <span class="material-symbols-outlined">
                                    check
                                </span>
                            </span>';
            } else {
                $taskIcon = '<span class="tasksIcon pending">
                                <span class="material-symbols-outlined">
                                    pending
                                </span>
                            </span>';
            }

            //check task priority
            if($current->TaskPriority == 'High') {
                $taskStar = '<span class="tasksStar full">
                                <span class="material-symbols-outlined">
                                    star
                                </span>
                            </span>';
            } else {
                $taskStar = '<span class="tasksStar">
                                <span class="material-symbols-outlined">
                                    star
                                </span>
                            </span>';
            }

            echo '<li>
                    <span class="tasksIconName">
                        '.$taskIcon.'
                        <span class="tasksName">
                            '.$current->TaskName.'
                        </span>
                    </span>
                    '.$taskStar.'
                </li>';

            $current = $current->Next;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                            <a href="Dashboard.php" class="active">
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
                <!-- myTasks start -->
                <div class="myTasks">
                    <!-- tasksHead start -->
                    <div class="tasksHead">
                        <h2>My Tasks</h2>
                        <div class="tasksDots">
                            <span class="material-symbols-outlined">
                                more_horiz
                            </span>
                        </div>
                    </div>
                    <!-- tasksHead end -->
                    <!-- tasks start -->
                    <div class="tasks">
                        <ul>
                            <?php
                            //get tasks from database
                            include 'DataBaseConnection\DataBaseConnection.php';

                            $sql = "SELECT TaskName, TaskStatus, TaskPriority FROM task WHERE UserEmail = '$UserEmail' AND DueDate = CURDATE()";
                            $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                $list = new LinkedList();
                                while($row = mysqli_fetch_assoc($result)) {
                                    $list->Add($row['TaskName'], $row['TaskStatus'], $row['TaskPriority']);
                                }
                                $list->Display();
                            } else {
                                echo '<li>
                                        <span class="tasksIconName">
                                            <span class="tasksIcon done">
                                                <span class="material-symbols-outlined">
                                                    check
                                                </span>
                                            </span>
                                            <span class="tasksName">
                                                No tasks due today.
                                            </span>
                                        </span>
                                        <span class="tasksStar full">
                                            <span class="material-symbols-outlined">
                                                star
                                            </span>
                                        </span>
                                    </li>';
                            }
                            ?>
                        </ul>
                    </div>
                <!-- tasks ens -->
                </div>
                <!-- myTasks end -->
            </div>
        </main>
    </div>
    <script src="JavaScript/script.js"></script>
</body>

</html>
