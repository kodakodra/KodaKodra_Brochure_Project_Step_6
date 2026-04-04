<?php

/**
 * auth.php
 *
 * Authentication guard — protects pages that require a logged-in user.
 * Include this at the top of any page that should only be accessible
 * when a user is logged in. Redirects to login.php if not.
 *
 * Usage:
 *   require_once 'includes/auth.php';
 */

// Start the session if one isn't already running
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If there's no user ID in the session, they aren't logged in
// Redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
