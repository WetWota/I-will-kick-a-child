<?php
ob_start();
session_start(); // Start the session

// Check if the session variable is set
if (!isset($_SESSION['account_type'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}
if ($_SESSION['account_type'] != 'student') {
    header("Location: Home.php"); // Redirect if not a student
    exit();
}
// Now that we know the session variable is set, check its value
if ($_SESSION['account_type'] == 'student') {
    header("Location: Student_Home.php"); // Redirect if not a student
    exit();
}

// Continue with the rest of the code for students here

ob_end_flush();
?>