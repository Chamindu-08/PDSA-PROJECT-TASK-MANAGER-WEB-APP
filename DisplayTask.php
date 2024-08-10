<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
    <link rel="stylesheet" href="JavaScript/script.js">
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

            <div class="main">
                <div class="cards">
                    <div class="card">
                        <div class="cardInner">
                            <div class="cardTitle">
                                <h2>Task Completed</h2>
                            </div>
                            <div class="cardMain">
                                <h2>20</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="cardInner">
                            <div class="cardTitle">
                                <h2>Task Pending</h2>
                            </div>
                            <div class="cardMain">
                                <h2>10</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="cardInner">
                            <div class="cardTitle">
                                <h2>Task Overdue</h2>
                            </div>
                            <div class="cardMain">
                                <h2>5</h2>
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
