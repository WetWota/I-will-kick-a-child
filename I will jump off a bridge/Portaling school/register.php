<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $account_type = $_POST['account_type'];

    // Validate data (this is a simple example, you should add more validation)
    if (!empty($name) && !empty($username) && !empty($password) && !empty($account_type)) {
        // Prepare data to be saved
        $data = "$username,$name,$password,$account_type," . date('Y-m-d H:i:s') . "\n";

        // Save to accounts.csv (make sure the web server has write permissions to this file)
        file_put_contents('assets/Database/accounts.csv', $data, FILE_APPEND);
        
        // Redirect to home page or show a success message
        header('Location: index.php');
        exit();
    } else {
        echo "All fields are required.";
    }
}
?>