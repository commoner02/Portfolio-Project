<?php
// Start session to store messages
session_start();

// Include database configuration
include("db-config.php");

// Initialize variables
$success_message = "";
$error_message = "";

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sendEmail'])) {
    // Check honeypot field (should be empty)
    if (!empty($_POST['website'])) {
        // Likely a bot, just redirect back
        header("Location: index.php#contacts");
        exit;
    }

    // Validate and sanitize input data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        $error_message = 'All fields are required.';
        $_SESSION['error_message'] = $error_message;
        // Preserve form values in session
        $_SESSION['form_values'] = $_POST;
        header("Location: index.php#contacts");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email format.';
        $_SESSION['error_message'] = $error_message;
        // Preserve form values in session
        $_SESSION['form_values'] = $_POST;
        header("Location: index.php#contacts");
        exit;
    }

    try {
        // Prepare and execute database query using prepared statements
        $insert_query = "INSERT INTO `messages` (name, email, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connection, $insert_query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);
            
            if (mysqli_stmt_execute($stmt)) {
                $success_message = 'Message sent successfully!';
                $_SESSION['success_message'] = $success_message;
            } else {
                $error_message = 'Database error: ' . mysqli_error($connection);
                $_SESSION['error_message'] = $error_message;
                // Preserve form values in session
                $_SESSION['form_values'] = $_POST;
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $error_message = 'Database error: ' . mysqli_error($connection);
            $_SESSION['error_message'] = $error_message;
            // Preserve form values in session
            $_SESSION['form_values'] = $_POST;
        }
    } catch (Exception $e) {
        $error_message = 'An error occurred: ' . $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        // Preserve form values in session
        $_SESSION['form_values'] = $_POST;
    }
} else {
    $error_message = 'Invalid request.';
    $_SESSION['error_message'] = $error_message;
}

// Close database connection
mysqli_close($connection);

// Redirect back to the form
header("Location: index.php#contacts");
exit;
?>