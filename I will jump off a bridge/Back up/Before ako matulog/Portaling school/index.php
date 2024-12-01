<?php
// Start output buffering
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Portal - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .login-container {
            max-width: 300px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .register-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form id="loginForm" action="index.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Login">
        </form>
        <div class="register-link">
            <a href="register.html">Register</a>
        </div>
    </div>

    <?php
    // PHP code to handle login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Read the accounts.csv file
        $file = fopen('assets/Database/accounts.csv', 'r');
        $login_success = false;

        while (($line = fgetcsv($file)) !== FALSE) {
            // Assuming the CSV format is: username,name,password,account_type,date_created
            if ($line[0] == $username && $line[2] == $password) {
                // Login successful
                $login_success = true;
                break;
            }
        }
        fclose($file);

        if ($login_success) {
            // Redirect to home page after successful login
            header('Location: home.php');
            session_start();
            $_SESSION['account_type'] = $line[3];
            $_SESSION['username'] = $username;
            exit();
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    }
    ?>

<?php
// Flush the output buffer
ob_end_flush();
?>
</body>
</html>