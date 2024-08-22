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
$sql = "SELECT COUNT(TaskStatus) AS TaskCompleted FROM task WHERE TaskStatus = 'COMPLETED' AND UserEmail = '$UserEmail' AND DueDate = CURDATE()";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $taskCompleted = $row['TaskCompleted'];
    }
} else {
    $taskCompleted = 0;
}

//get task count
$sql = "SELECT COUNT(TaskStatus) AS TaskPending FROM task WHERE TaskStatus = 'PENDING' AND UserEmail = '$UserEmail' AND DueDate = CURDATE()";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $taskPending = $row['TaskPending'];
    }
} else {
    $taskPending = 0;
}

//get task count
$sql = "SELECT COUNT(TaskStatus) AS TaskOverdue FROM task WHERE TaskStatus = 'OVERDUE' AND UserEmail = '$UserEmail' AND DueDate = CURDATE()";
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

//node class
class Node {
    public $TaskName;
    public $TaskDescription;
    public $TaskStatus;
    public $TaskPriority;
    public $DueDate;
    public $Next;

    public function __construct($TaskName, $TaskDescription, $TaskStatus, $TaskPriority, $DueDate) {
        $this->TaskName = $TaskName;
        $this->TaskDescription = $TaskDescription;
        $this->TaskStatus = $TaskStatus;
        $this->TaskPriority = $TaskPriority;
        $this->DueDate = $DueDate;
        $this->Next = null;
    }
}

//linked list class
class LinkedList {
    public $head;

    //insert node
    public function addEnd($TaskName, $TaskDescription, $TaskStatus, $TaskPriority, $DueDate) {
        //create a new node
        $newNode = new Node($TaskName, $TaskDescription, $TaskStatus, $TaskPriority, $DueDate);

        //check if the list is empty
        if ($this->head == null) {
            $this->head = $newNode;
        } else {
            //traverse to the end of the list
            $current = $this->head;
            while ($current->Next != null) {
                $current = $current->Next;
            }
            $current->Next = $newNode;
        }
    }

    //sort linked list
    public function sort() {
        $current = $this->head;
        $index = null;

        if ($this->head == null) {
            return;
        } else {
            while ($current != null) {
                $index = $current->Next;

                while ($index != null) {
                    if ($this->priorityToValue($current->TaskPriority) > $this->priorityToValue($index->TaskPriority)) {
                        $tempTaskName = $current->TaskName;
                        $current->TaskName = $index->TaskName;
                        $index->TaskName = $tempTaskName;

                        $tempTaskDescription = $current->TaskDescription;
                        $current->TaskDescription = $index->TaskDescription;
                        $index->TaskDescription = $tempTaskDescription;

                        $tempTaskStatus = $current->TaskStatus;
                        $current->TaskStatus = $index->TaskStatus;
                        $index->TaskStatus = $tempTaskStatus;

                        $tempTaskPriority = $current->TaskPriority;
                        $current->TaskPriority = $index->TaskPriority;
                        $index->TaskPriority = $tempTaskPriority;

                        $tempDueDate = $current->DueDate;
                        $current->DueDate = $index->DueDate;
                        $index->DueDate = $tempDueDate;
                    } 
                    $index = $index->Next;
                }
                $current = $current->Next;
            }
        }
    }

    //sort linked list low to high
    public function sortLowToHigh() {
        $current = $this->head;
        $index = null;

        if ($this->head == null) {
            return;
        } else {
            while ($current != null) {
                $index = $current->Next;

                while ($index != null) {
                    if ($this->priorityToValue($current->TaskPriority) < $this->priorityToValue($index->TaskPriority)) {
                        $tempTaskName = $current->TaskName;
                        $current->TaskName = $index->TaskName;
                        $index->TaskName = $tempTaskName;

                        $tempTaskDescription = $current->TaskDescription;
                        $current->TaskDescription = $index->TaskDescription;
                        $index->TaskDescription = $tempTaskDescription;

                        $tempTaskStatus = $current->TaskStatus;
                        $current->TaskStatus = $index->TaskStatus;
                        $index->TaskStatus = $tempTaskStatus;

                        $tempTaskPriority = $current->TaskPriority;
                        $current->TaskPriority = $index->TaskPriority;
                        $index->TaskPriority = $tempTaskPriority;

                        $tempDueDate = $current->DueDate;
                        $current->DueDate = $index->DueDate;
                        $index->DueDate = $tempDueDate;
                    } 
                    $index = $index->Next;
                }
                $current = $current->Next;
            }
        }
    }

    //convert priority level to numerical value for sorting
    private function priorityToValue($priority) {
        switch ($priority) {
            case 'High':
                return 1;
            case 'Medium':
                return 2;
            case 'Low':
                return 3;
            default:
                return 4;
        }
    }

    //delete node
    public function delete($TaskName) {
        $current = $this->head;

        if ($current->TaskName == $TaskName) {
            $this->head = $current->Next;
        } else {
            while ($current->Next != null) {
                if ($current->Next->TaskName == $TaskName) {
                    $current->Next = $current->Next->Next;
                    break;
                }
                $current = $current->Next;
            }
        }
    }

    //display task
    public function display() {
        $current = $this->head;
        $count = 1;

        if ($current == null) {
            echo '<div class="projectCard">
                    <div class="projectTop">
                        <h2>No Task Found</h2>
                    </div>
                </div>';
            exit();
        } else {
            while ($current != null) {
                echo '<div class="projectCard">
                        <div class="projectTop">
                            <h2>Task '.$count.'<br><span>'.$current->TaskName.'</span></h2>
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
                                <h2>'.$current->TaskPriority.' Priority</h2>
                            </div>
                        </div>
    
                        <div class="projectDiscription">
                            <h2>Task Description</h2>
                            <p>'.$current->TaskDescription.'</p>
                        </div>
                
                        <div class="date">
                            <h2>Due Date <br><span>'.$current->DueDate.'</span></h2>
                        </div>
                    </div>';
    
                $current = $current->Next;
                $count = $count + 1;
            }
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
    <title>Task</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS\taskStyle.css">
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
                            <a href="ViewProfile.php">
                                <span class="material-symbols-outlined">account_circle</span>
                                <span class="title">Profile</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="logout">
                    <button onclick="window.location.href = 'LogOut.php';">
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
                            <li><a href="ViewProfile.php" class="dropdown-item">
                                <span class="material-symbols-outlined">account_circle</span> 
                                Profile</a>
                            </li>
                            <li><a href="ViewProfile.php" class="dropdown-item">
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
            <!-- select task order -->
            <div class="taskOrder">
                <div class="taskOrderTitle">
                    <h2>Task Order</h2>
                </div>
                <div class="taskOrderMain">
                    <form method="GET" action="DisplayTask.php">
                        <select class = "taskOrderSelect" name="taskOrder" onchange="this.form.submit()">
                            <option value="high" <?php if (!isset($_GET['taskOrder']) || $_GET['taskOrder'] == 'high') echo 'selected'; ?>>High to Low</option>
                            <option value="low" <?php if (isset($_GET['taskOrder']) && $_GET['taskOrder'] == 'low') echo 'selected'; ?>>Low to High</option>
                        </select>
                    </form>
                </div>
            </div>

            <?php 
            //display task
            include 'DataBaseConnection\DataBaseConnection.php';

            //get task
            $sql = "SELECT * FROM task WHERE UserEmail = '$UserEmail' AND TaskStatus != 'COMPLETED' AND DueDate = CURDATE()";
            $result = mysqli_query($connection, $sql);

            $list = new LinkedList();

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $list->addEnd($row['TaskName'], $row['TaskDescription'], $row['TaskStatus'], $row['TaskPriority'], $row['DueDate']);
                }
            } else {
                echo '<script>
                        var confirmMsg = confirm("No task found.");
                        if (confirmMsg) {
                            window.location.href = "AddTask.php";
                        }
                    </script>';
                exit();
            }

            //close connection
            mysqli_close($connection);

            //sort task
            if (!isset($_GET['taskOrder']) || $_GET['taskOrder'] == 'high') {
                $list->sort();
            } else {
                $list->sortLowToHigh();
            }

            //display task
            $list->display();
            ?>

        </main>
    </div>
    <script src="JavaScript/script.js"></script>
</body>

</html>