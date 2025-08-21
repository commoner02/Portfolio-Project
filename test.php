<?php
$to = "77.shuvo.joy@gmail.com";
$subject = "Test Email";
$message = "This is a test email from your server";
$headers = "From: webmaster@yoursite.com";

if(mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Email sending failed!";
}