<?php
//add page to the session
session_start();

//delete the session
session_destroy();

//redirect to logout
header("Location: LoginAndRegister.php");
?>