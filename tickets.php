<?php
/* ============================================================
   tickets.php — User's ticket list and new ticket form
   ============================================================
   Shows all tickets belonging to the logged-in user.
   Includes a form to open a new ticket.
   ============================================================ */

global $pdo;
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Fetch all tickets for this user, most recent first
$stmt = $pdo->prepare('
    SELECT id, subject, status, created_at, updated_at
    FROM tickets
    WHERE user_id = ?
    ORDER BY updated_at DESC
');
$stmt->execute([$_SESSION['user_id']]);
$tickets = $stmt->fetchAll();

// Simple error messages from ticket-handler.php redirects
$errors = [
    'invalid_subject' => 'Please enter a valid subject (max 150 characters).',
    'invalid_message' => 'Please enter a message.',
    'server'          => 'Something went wrong. Please try again.',
];
$errorMsg = $errors[$_GET['error'] ?? ''] ?? '';

$pageTitle = 'Support Tickets';
require_once 'includes/header.php';
?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">Support</p>
            <h1 class="page-title">Your Tickets</h1>
            <p class="page-sub"><?= count($tickets) ?> ticket<?= count($tickets) !== 1 ? 's' : '' ?> on record.</p>
        </div>
    </div>

    <section id="tickets">
        <div class="container">
            <div class="row g-5">

                <!-- Ticket List -->
                <div class="col-md-8">

                    <?php if ($errorMsg): ?>
                        <div class="form-msg form-msg--error mb-4"><?= htmlspecialchars($errorMsg) ?></div>
                    <?php endif; ?>

                    <?php if (empty($tickets)): ?>
                        <p style="font-size: 0.88rem; color: var(--clr-muted);">No tickets yet. Use the form to open one.</p>
                    <?php else: ?>
                        <div class="ticket-list">
                            <?php foreach ($tickets as $t): ?>
                                <a href="ticket.php?id=<?= $t['id'] ?>" class="ticket-row">
                                    <div class="ticket-row__main">
                                        <span class="ticket-row__subject"><?= htmlspecialchars($t['subject']) ?></span>
                                        <span class="ticket-row__meta">
                                            Opened <?= date('d M Y', strtotime($t['created_at'])) ?>
                                            &mdash; Updated <?= date('d M Y', strtotime($t['updated_at'])) ?>
                                        </span>
                                    </div>
                                    <span class="ticket-badge ticket-badge--<?= $t['status'] ?>">
                                        <?= ucfirst($t['status']) ?>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- New Ticket Form -->
                <div class="col-md-4">
                    <div class="dashboard-card">
                        <div class="dashboard-card__icon"><i class="fas fa-plus"></i></div>
                        <h5>Open a Ticket</h5>

                        <form method="POST" action="ticket-handler.php">
                            <input type="hidden" name="action" value="create">

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control"
                                       placeholder="Brief summary of your issue" maxlength="150" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea id="message" name="message" class="form-control"
                                          rows="5" placeholder="Describe your issue..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-accent w-100">Submit Ticket</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
