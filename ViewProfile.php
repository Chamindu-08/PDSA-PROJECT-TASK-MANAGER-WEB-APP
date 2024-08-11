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

// Check if form is submitted
if (isset($_POST['update'])) {
    // Connect to database
    include 'DataBaseConnection/DataBaseConnection.php';

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactNo = $_POST['contactNo'];
    $position = $_POST['position'];

    // Update data in database
    $sql = "UPDATE user SET UserName='$name', UserEmail='$email', UserPosition='$position' WHERE UserEmail='$UserEmail'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        // Update the session with the new values
        setcookie('UserEmail', $email, time() + (86400 * 30), "/");
        setcookie('UserName', $name, time() + (86400 * 30), "/");
        setcookie('UserPosition', $position, time() + (86400 * 30), "/");

        echo '<script>
                alert("Profile updated successfully.");
                window.location.href = "ViewProfile.php";
              </script>';
    } else {
        echo '<script>
                alert("Error updating profile.");
                window.location.href = "ViewProfile.php";
              </script>';
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
    <title>Profile Update</title>
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
                        </li>
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
                            <a href="ViewProfile.php" class="active">
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
                    <h2>Profile</h2>
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

            <!-- Update Profile Form -->
            <div class="TaskForm">
                <form method="post" action="#">
                    <table>
                        <tr>
                            <h2>Personal Information</h2>
                        </tr>
                        <tr>
                            <td><label for="name">Name:</label><br>
                            <input type="text" id="name" name="name" value="<?php echo $UserName; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email:</label><br>
                            <input type="email" id="email" name="email" value="<?php echo $UserEmail; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="contactNo">Contact No:</label><br>
                            <input type="text" id="contactNo" name="contactNo" value="0123456789" required></td>
                        </tr>
                        <tr>
                            <td><label for="position">Position:</label><br>
                            <input type="text" id="position" name="position" value="<?php echo $UserPosition; ?>" required></td>
                        </tr>
                        <tr>
                            <td><button type="submit" name="update" onclick="return confirm('Are you sure you want to update profile?');">Update</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </main>
    </div>
    <script src="JavaScript/script.js"></script>
</body>

</html>
