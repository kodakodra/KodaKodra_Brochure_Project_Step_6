<?php

/**
 * admin-auth.php
 *
 * Admin guard — protects pages that require admin role.
 * Include this at the top of any admin-only page.
 * Redirects to login if not logged in, or home if logged in but not admin.
 *
 * Usage:
 *   require_once 'includes/admin-auth.php';
 */

// Start the session if one isn't already running
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Not logged in at all — send to login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Logged in but not admin — send to home, nothing to see here
if ($_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
