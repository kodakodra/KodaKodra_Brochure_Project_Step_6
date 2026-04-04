<?php global $pdo;

/**
 * contact-handler.php
 *
 * Handles contact form submissions.
 * Validates input, stores the submission in the database,
 * sends an email via PHPMailer, and returns a JSON response.
 * Called via fetch() in script.js — not visited directly.
 */

require_once 'includes/config.php';
require_once 'includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/phpmailer/phpmailer/src/Exception.php';
require_once 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once 'vendor/phpmailer/phpmailer/src/SMTP.php';

// Start session so we can check if a user is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

header('Content-Type: application/json');

/* ===========================
   Sanitise & Validate Input
=========================== */

$name    = trim(strip_tags($_POST['name']    ?? ''));
$email   = trim(strip_tags($_POST['email']   ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required.';
} elseif (strlen($name) > 100) {
    $errors[] = 'Name must be 100 characters or fewer.';
}

if (empty($email)) {
    $errors[] = 'Email address is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}

if (empty($message)) {
    $errors[] = 'Message is required.';
} elseif (strlen($message) > 5000) {
    $errors[] = 'Message must be 5000 characters or fewer.';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

/* ===========================
   Store Submission in Database
=========================== */

// If a user is logged in, record their ID — otherwise store NULL (guest)
$userId = $_SESSION['user_id'] ?? null;

try {
    $stmt = $pdo->prepare('
        INSERT INTO submissions (user_id, name, email, message)
        VALUES (?, ?, ?, ?)
    ');
    $stmt->execute([$userId, $name, $email, $message]);

} catch (PDOException $e) {
    // Log the real error and return a safe message
    error_log('Submission insert failed: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Something went wrong saving your message. Please try again.']);
    exit;
}

/* ===========================
   Send Email via PHPMailer
=========================== */

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = MAIL_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = MAIL_USERNAME;
    $mail->Password   = MAIL_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = MAIL_PORT;

    $mail->setFrom(MAIL_USERNAME, MAIL_FROM_NAME);
    $mail->addReplyTo($email, $name);
    $mail->addAddress(MAIL_TO, MAIL_TO_NAME);

    $mail->Subject = 'New Contact Form Submission — ' . SITE_NAME;
    $mail->Body    =
        "Name:    $name\n" .
        "Email:   $email\n" .
        "User ID: " . ($userId ?? 'Guest') . "\n\n" .
        "Message:\n$message";

    $mail->send();

} catch (Exception $e) {
    // Email failure is logged but doesn't affect the response —
    // the submission is already saved in the database
    error_log('PHPMailer error: ' . $mail->ErrorInfo);
}

// Return success regardless of email outcome — data is safely stored
echo json_encode(['success' => true, 'message' => 'Message sent! I\'ll get back to you within 24 hours.']);
