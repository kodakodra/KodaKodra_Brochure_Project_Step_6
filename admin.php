<?php global $pdo;

/**
 * admin.php
 *
 * Admin panel — lists all contact form submissions.
 * Accessible to admin users only via admin-auth.php.
 */

require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/admin-auth.php';

/* ===========================
   Fetch All Submissions
=========================== */

// Pull all submissions, most recent first
// LEFT JOIN brings in the user's name if they were logged in when submitting
$stmt = $pdo->query('
    SELECT
        s.id,
        s.name,
        s.email,
        s.message,
        s.created_at,
        u.name  AS account_name,
        u.email AS account_email
    FROM submissions s
    LEFT JOIN users u ON s.user_id = u.id
    ORDER BY s.created_at DESC
');

$submissions = $stmt->fetchAll();

$pageTitle = 'Admin — Submissions';
require_once 'includes/header.php';
?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">Admin</p>
            <h1 class="page-title">Contact Submissions</h1>
            <p class="page-sub"><?= count($submissions) ?> submission<?= count($submissions) !== 1 ? 's' : '' ?> total.</p>
        </div>
    </div>

    <!-- Submissions Table -->
    <section id="submissions">
        <div class="container">

            <?php if (empty($submissions)): ?>
                <p class="text-muted" style="font-size: 0.88rem;">No submissions yet.</p>

            <?php else: ?>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Account</th>
                            <th>Message</th>
                            <th>Submitted</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($submissions as $sub): ?>
                            <tr>
                                <td><?= $sub['id'] ?></td>
                                <td data-label="Name"><?= htmlspecialchars($sub['name']) ?></td>
                                <td data-label="Email">
                                    <a href="mailto:<?= htmlspecialchars($sub['email']) ?>">
                                        <?= htmlspecialchars($sub['email']) ?>
                                    </a>
                                </td>
                                <td data-label="Account">
                                    <?php if ($sub['account_name']): ?>
                                        <?= htmlspecialchars($sub['account_name']) ?>
                                        <span class="admin-meta"><?= htmlspecialchars($sub['account_email']) ?></span>
                                    <?php else: ?>
                                        <span class="admin-meta">Guest</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Message" title="<?= htmlspecialchars($sub['message']) ?>">
                                    <?= htmlspecialchars(mb_strimwidth($sub['message'], 0, 80, '...')) ?>
                                </td>
                                <td data-label="Submitted"><?= date('d M Y, H:i', strtotime($sub['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
