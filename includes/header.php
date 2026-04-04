<?php

/**
 * header.php
 *
 * Reusable header include — outputs the full <head> block and navbar.
 * Include this at the top of every page.
 *
 * Expects $pageTitle to be set before including, e.g:
 *   $pageTitle = 'About';
 *   require_once 'includes/header.php';
 *
 * Navbar is session-aware — shows login/register or dashboard/logout
 * depending on whether the user is logged in.
 */

// Start the session if one isn't already running
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Convenience variable — true if the user is logged in
$loggedIn = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title uses $pageTitle if set, falls back to site name alone -->
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — ' . SITE_NAME : SITE_NAME ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="../style.css" rel="stylesheet">
</head>
<body>

<!-- ===========================
     Navbar
=========================== -->
<nav class="navbar navbar-expand-md fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../index.php"><?= SITE_NAME ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <!-- Main nav links -->
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'about.php' ? 'active' : '' ?>" href="../about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'services.php' ? 'active' : '' ?>" href="../services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'contact.php' ? 'active' : '' ?>" href="../contact.php">Contact</a>
                </li>

                <!-- Auth links — change based on login state -->
                <?php if ($loggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>" href="../dashboard.php">
                            <i class="fas fa-user"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'login.php' ? 'active' : '' ?>" href="../login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'register.php' ? 'active' : '' ?>" href="../register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
