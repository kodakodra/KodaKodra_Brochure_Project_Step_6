<?php

/**
 * config.php
 *
 * Central configuration file for the KodaKodra portfolio site.
 * All global constants and settings are defined here.
 * Include this file at the top of any PHP file that needs it.
 */

/* ===========================
   Site Settings
=========================== */

// The name of the site, used in page titles and branding
define('SITE_NAME', 'KodaKodra');

// Base URL of the site — update this when deploying
define('SITE_URL', 'http://localhost');

/* ===========================
   Database Settings
=========================== */

// MySQL host — usually localhost for local development
define('DB_HOST', 'localhost');

// The database name created in migration.sql
define('DB_NAME', 'kodakodra');

// Your MySQL username
define('DB_USER', 'root');

// Your MySQL password — move to .env before deploying
define('DB_PASS', '');

/* ===========================
   Mail Settings
=========================== */

// The address all contact form submissions will be sent to
define('MAIL_TO', 'admin@example.com');

// The name that appears in the "To" field of received emails
define('MAIL_TO_NAME', 'KodaKodra');

// SMTP host — using Gmail here, change if using a different provider
define('MAIL_HOST', 'smtp.gmail.com');

// SMTP port — 587 for TLS (recommended for Gmail)
define('MAIL_PORT', 587);

// Your Gmail address used to send emails via SMTP
define('MAIL_USERNAME', 'admin@example.com');

// Your Gmail App Password — generate one at myaccount.google.com/apppasswords
// Never commit this to a public repo — move to .env before deploying
define('MAIL_PASSWORD', 'your-app-password-here');

// The name that appears in the "From" field of sent emails
define('MAIL_FROM_NAME', 'KodaKodra Contact Form');
