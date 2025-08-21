<?php
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get and sanitize form data
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

// Simple spam protection - honeypot field
$honeypot = isset($_POST['website']) ? $_POST['website'] : '';

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Please provide a valid email address']);
    exit;
}

// Check message length
if (strlen($message) < 10) {
    http_response_code(400);
    echo json_encode(['error' => 'Message should be at least 10 characters long']);
    exit;
}

// Check honeypot (if filled, likely a bot)
if (!empty($honeypot)) {
    // Log this attempt if you want, but just return success to bots
    echo json_encode(['success' => true]);
    exit;
}

// Email configuration
$to = "77.shuvo.joy@gmail.com";
$subject = "New Contact Form Message from $name";
$body = "Name: $name\nEmail: $email\nMessage:\n$message";

// Email headers
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email
if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to send message. Please try again later.']);
}
?>