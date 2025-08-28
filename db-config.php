<?php
 
$db_host='localhost';
$db_user='portfolio_user';
$password='commoner02';
$db_name='portfolio_db';

$connection=mysqli_connect($db_host,$db_user,$password,$db_name);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>