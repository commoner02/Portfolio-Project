<?php

require_once 'config.php';


function checkLogin($username, $password)
{
    global $pdo;

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();

        if (password_verify($password, $user['password'])) {
            return true; // Login successful
        }
    }

    return false;
}

function isLoggedIn()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function protectPage()
{
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

?>