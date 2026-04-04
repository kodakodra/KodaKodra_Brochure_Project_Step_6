<?php
/* ============================================================
   register.php — User registration
   ============================================================
   Displays the registration form and handles submission.
   Validates input, checks for duplicate emails, hashes the
   password, and inserts the new user into the database.
   ============================================================ */

global $pdo;
require_once 'includes/config.php';
require_once 'includes/db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, no need to register — send them to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $name     = trim(strip_tags($_POST['name']     ?? ''));
    $email    = trim(strip_tags($_POST['email']    ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm']  ?? '';

    // Validate
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $error = 'All fields are required.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';

    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';

    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';

    } else {
        // Check if the email is already registered
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'That email address is already registered.';
        } else {
            // Hash the password securely using bcrypt
            $hash = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user — role defaults to 'user' in the database
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$name, $email, $hash]);

            $success = 'Account created! You can now log in.';
        }
    }
}

$pageTitle = 'Register';
require_once 'includes/header.php';
?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">Account</p>
            <h1 class="page-title">Register</h1>
            <p class="page-sub">Create an account to access your dashboard and submit support tickets.</p>
        </div>
    </div>

    <!-- Register Form -->
    <section id="register">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5">

                    <?php if ($error): ?>
                        <div class="form-msg form-msg--error mb-4"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="form-msg form-msg--success mb-4">
                            <?= htmlspecialchars($success) ?>
                            <a href="login.php">Log in here.</a>
                        </div>
                    <?php else: ?>

                        <form method="POST" action="register.php" novalidate>

                            <div class="mb-4">
                                <label for="name" class="form-label">Name <span class="text-danger ms-1">*</span></label>
                                <input type="text" id="name" name="name" class="form-control"
                                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                                       maxlength="100" required>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address <span class="text-danger ms-1">*</span></label>
                                <input type="email" id="email" name="email" class="form-control"
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password <span class="text-danger ms-1">*</span></label>
                                <input type="password" id="password" name="password" class="form-control"
                                       minlength="8" required>
                            </div>

                            <div class="mb-4">
                                <label for="confirm" class="form-label">Confirm Password <span class="text-danger ms-1">*</span></label>
                                <input type="password" id="confirm" name="confirm" class="form-control"
                                       minlength="8" required>
                            </div>

                            <button type="submit" class="btn btn-accent">Create Account</button>

                        </form>

                        <p class="mt-4" style="font-size: 0.82rem; color: var(--clr-muted);">
                            Already have an account? <a href="login.php">Log in here.</a>
                        </p>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
