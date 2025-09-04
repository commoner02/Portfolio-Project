<?php

$db_host = "localhost";
$db_name = "portfolio_db";
$db_user = "portfolio_user";
$db_pass = "commoner02";

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch (PDOException $e) {
    echo "Cannot connect to database";
    exit;
}

session_start();

?>
