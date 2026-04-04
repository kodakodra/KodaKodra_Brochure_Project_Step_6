<?php
/* ============================================================
   login.php — User login
   ============================================================
   Displays the login form and handles submission.
   Looks up the user by email, verifies the password hash,
   and starts an authenticated session on success.
   ============================================================ */

global $pdo;
require_once 'includes/config.php';
require_once 'includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Already logged in — redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim(strip_tags($_POST['email']    ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter your email and password.';

    } else {
        // Look up the user by email
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verify the password against the stored hash
        if (!$user || !password_verify($password, $user['password'])) {
            // Deliberately vague — don't confirm whether the email exists
            $error = 'Invalid email or password.';

        } else {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Store user info in the session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            header('Location: dashboard.php');
            exit;
        }
    }
}

$pageTitle = 'Login';
require_once 'includes/header.php';
?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">Account</p>
            <h1 class="page-title">Login</h1>
            <p class="page-sub">Log in to access your dashboard.</p>
        </div>
    </div>

    <!-- Login Form -->
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5">

                    <?php if ($error): ?>
                        <div class="form-msg form-msg--error mb-4"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="login.php" novalidate>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address <span class="text-danger ms-1">*</span></label>
                            <input type="email" id="email" name="email" class="form-control"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password <span class="text-danger ms-1">*</span></label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-accent">Log In</button>

                    </form>

                    <p class="mt-4" style="font-size: 0.82rem; color: var(--clr-muted);">
                        Don't have an account? <a href="register.php">Register here.</a>
                    </p>

                </div>
            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
