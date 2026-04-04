<?php global $pdo;

/**
 * dashboard.php
 *
 * Logged-in user's personal dashboard.
 * Shows account info, contact submission count, and ticket summary.
 * Admin users also see links to the admin panels.
 */

require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Count this user's contact submissions
$stmt = $pdo->prepare('SELECT COUNT(*) FROM submissions WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$submissionCount = $stmt->fetchColumn();

// Fetch this user's tickets with counts per status
$stmt = $pdo->prepare('
    SELECT status, COUNT(*) AS total
    FROM tickets
    WHERE user_id = ?
    GROUP BY status
');
$stmt->execute([$_SESSION['user_id']]);
$ticketRows = $stmt->fetchAll();

// Map status => count for easy access in the view
$ticketCounts = ['open' => 0, 'pending' => 0, 'closed' => 0];
foreach ($ticketRows as $row) {
    $ticketCounts[$row['status']] = $row['total'];
}

$totalTickets = array_sum($ticketCounts);

$pageTitle = 'Dashboard';
require_once 'includes/header.php';
?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">Dashboard</p>
            <h1 class="page-title">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
            <p class="page-sub">Logged in as <?= htmlspecialchars($_SESSION['user_role']) ?>.</p>
        </div>
    </div>

    <section id="dashboard">
        <div class="container">
            <div class="row g-4">

                <!-- Account Info -->
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="dashboard-card__icon"><i class="fas fa-user"></i></div>
                        <h5>Account</h5>
                        <p>Logged in as <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>.</p>
                        <p>Role: <strong><?= htmlspecialchars($_SESSION['user_role']) ?></strong></p>
                    </div>
                </div>

                <!-- Submissions -->
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="dashboard-card__icon"><i class="fas fa-envelope"></i></div>
                        <h5>Submissions</h5>
                        <p><strong><?= $submissionCount ?></strong> contact form submission<?= $submissionCount != 1 ? 's' : '' ?>.</p>
                    </div>
                </div>

                <!-- Tickets -->
                <div class="col-md-6 col-lg-3">
                    <div class="dashboard-card">
                        <div class="dashboard-card__icon"><i class="fas fa-ticket"></i></div>
                        <h5>Support Tickets</h5>
                        <p><strong><?= $totalTickets ?></strong> ticket<?= $totalTickets != 1 ? 's' : '' ?> total.</p>
                        <?php if ($ticketCounts['open'] || $ticketCounts['pending']): ?>
                            <p>
                                <?php if ($ticketCounts['open']): ?>
                                    <span class="ticket-badge ticket-badge--open"><?= $ticketCounts['open'] ?> Open</span>
                                <?php endif; ?>
                                <?php if ($ticketCounts['pending']): ?>
                                    <span class="ticket-badge ticket-badge--pending"><?= $ticketCounts['pending'] ?> Pending</span>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                        <a href="tickets.php" class="btn btn-outline-accent mt-2" style="font-size: 0.75rem; padding: 8px 16px;">View Tickets</a>
                    </div>
                </div>

                <!-- Admin Links — visible to admins only -->
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="dashboard-card">
                            <div class="dashboard-card__icon"><i class="fas fa-shield-halved"></i></div>
                            <h5>Admin</h5>
                            <p>Manage all submissions and tickets.</p>
                            <a href="admin.php" class="btn btn-accent mt-2" style="font-size: 0.75rem; padding: 8px 16px;">Submissions</a>
                            <a href="admin-tickets.php" class="btn btn-outline-accent mt-2" style="font-size: 0.75rem; padding: 8px 16px;">Tickets</a>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
