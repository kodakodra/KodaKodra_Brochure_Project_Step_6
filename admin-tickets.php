<?php
/* ============================================================
   admin-tickets.php — Admin view of all tickets
   ============================================================
   Lists all tickets across all users with status and owner.
   Accessible to admin users only.
   ============================================================ */

global $pdo;
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/admin-auth.php';

// Fetch all tickets, most recently updated first, with owner info
$stmt = $pdo->query('
    SELECT
        t.id,
        t.subject,
        t.status,
        t.created_at,
        t.updated_at,
        u.name  AS owner_name,
        u.email AS owner_email
    FROM tickets t
    JOIN users u ON t.user_id = u.id
    ORDER BY t.updated_at DESC
');
$tickets = $stmt->fetchAll();

$pageTitle = 'Admin — Tickets';
require_once 'includes/header.php';
?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">Admin</p>
            <h1 class="page-title">All Tickets</h1>
            <p class="page-sub"><?= count($tickets) ?> ticket<?= count($tickets) !== 1 ? 's' : '' ?> total.</p>
        </div>
    </div>

    <section id="admin-tickets">
        <div class="container">

            <?php if (empty($tickets)): ?>
                <p style="font-size: 0.88rem; color: var(--clr-muted);">No tickets yet.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th>Updated</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($tickets as $t): ?>
                            <tr>
                                <td><?= $t['id'] ?></td>
                                <td data-label="Subject"><?= htmlspecialchars($t['subject']) ?></td>
                                <td data-label="Owner">
                                    <?= htmlspecialchars($t['owner_name']) ?>
                                    <span class="admin-meta"><?= htmlspecialchars($t['owner_email']) ?></span>
                                </td>
                                <td data-label="Status">
                                    <span class="ticket-badge ticket-badge--<?= $t['status'] ?>">
                                        <?= ucfirst($t['status']) ?>
                                    </span>
                                </td>
                                <td data-label="Updated"><?= date('d M Y, H:i', strtotime($t['updated_at'])) ?></td>
                                <td data-label="Action">
                                    <a href="ticket.php?id=<?= $t['id'] ?>">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
