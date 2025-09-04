<?php

session_start();
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (checkLogin($username, $password)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        header("Location: index.php");
        exit();
    } else {
        $error = "Wrong username or password!";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mozilla+Text:wght@200..700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Mozilla Text', Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: orangered;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #e64100;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        #show-password {
            margin: 0;
            padding: 0;
        }

        .checkbox-label {
            padding-top: 5px;
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Admin Login</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <div class="checkbox-container">
                    <input type="checkbox" id="show-password" onclick="togglePassword()">
                    <label for="show-password" class="checkbox-label">Show Password</label>
                </div>
                <script>
                    function togglePassword() {
                        var passwordField = document.getElementById("password");
                        if (passwordField.type === "password") {
                            passwordField.type = "text";
                        } else {
                            passwordField.type = "password";
                        }
                    }
                </script>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>