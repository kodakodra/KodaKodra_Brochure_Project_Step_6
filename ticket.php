<?php
/* ============================================================
   ticket.php — Single ticket view with reply thread
   ============================================================
   Shows the full ticket thread.
   Allows the ticket owner and admins to reply or close.
   ============================================================ */

global $pdo;
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Get and validate the ticket ID from the URL
$ticketId = (int) ($_GET['id'] ?? 0);

if (!$ticketId) {
    header('Location: tickets.php');
    exit;
}

// Fetch the ticket — join the owner's name for display
$stmt = $pdo->prepare('
    SELECT t.*, u.name AS owner_name
    FROM tickets t
    JOIN users u ON t.user_id = u.id
    WHERE t.id = ?
');
$stmt->execute([$ticketId]);
$ticket = $stmt->fetch();

// Ticket not found
if (!$ticket) {
    header('Location: tickets.php?error=not_found');
    exit;
}

// Only the ticket owner or an admin can view the ticket
if ($ticket['user_id'] !== $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin') {
    header('Location: tickets.php?error=unauthorised');
    exit;
}

// Fetch all replies for this ticket, oldest first — builds the thread
$stmt = $pdo->prepare('
    SELECT r.*, u.name AS author_name, u.role AS author_role
    FROM ticket_replies r
    JOIN users u ON r.user_id = u.id
    WHERE r.ticket_id = ?
    ORDER BY r.created_at ASC
');
$stmt->execute([$ticketId]);
$replies = $stmt->fetchAll();

$errorMsg = $_GET['error'] === 'closed' ? 'This ticket is closed and cannot receive new replies.' : '';

$pageTitle = 'Ticket #' . $ticketId;
require_once 'includes/header.php';
?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <p class="page-label">Support &rsaquo; Ticket #<?= $ticketId ?></p>
            <h1 class="page-title"><?= htmlspecialchars($ticket['subject']) ?></h1>
            <p class="page-sub">
                Opened by <?= htmlspecialchars($ticket['owner_name']) ?>
                on <?= date('d M Y', strtotime($ticket['created_at'])) ?>.
                <span class="ticket-badge ticket-badge--<?= $ticket['status'] ?> ms-2">
                    <?= ucfirst($ticket['status']) ?>
                </span>
            </p>
        </div>
    </div>

    <section id="ticket">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <?php if ($errorMsg): ?>
                        <div class="form-msg form-msg--error mb-4"><?= htmlspecialchars($errorMsg) ?></div>
                    <?php endif; ?>

                    <!-- Reply Thread -->
                    <div class="ticket-thread mb-5">
                        <?php foreach ($replies as $reply): ?>
                            <div class="ticket-reply ticket-reply--<?= $reply['author_role'] === 'admin' ? 'admin' : 'user' ?>">
                                <div class="ticket-reply__header">
                                    <strong><?= htmlspecialchars($reply['author_name']) ?></strong>
                                    <?php if ($reply['author_role'] === 'admin'): ?>
                                        <span class="ticket-badge ticket-badge--admin">Admin</span>
                                    <?php endif; ?>
                                    <span class="admin-meta"><?= date('d M Y, H:i', strtotime($reply['created_at'])) ?></span>
                                </div>
                                <div class="ticket-reply__body">
                                    <?= nl2br(htmlspecialchars($reply['message'])) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Reply Form — hidden if ticket is closed -->
                    <?php if ($ticket['status'] !== 'closed'): ?>
                        <h5 style="font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 16px;">Add a Reply</h5>
                        <form method="POST" action="ticket-handler.php">
                            <input type="hidden" name="action" value="reply">
                            <input type="hidden" name="ticket_id" value="<?= $ticketId ?>">

                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="5"
                                          placeholder="Write your reply..." required></textarea>
                            </div>

                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-accent">Send Reply</button>

                                <!-- Close ticket button — only owner or admin -->
                                <form method="POST" action="ticket-handler.php" style="margin: 0;">
                                    <input type="hidden" name="action" value="close">
                                    <input type="hidden" name="ticket_id" value="<?= $ticketId ?>">
                                    <button type="submit" class="btn btn-outline-accent"
                                            onclick="return confirm('Close this ticket?')">
                                        Close Ticket
                                    </button>
                                </form>
                            </div>
                        </form>
                    <?php else: ?>
                        <p style="font-size: 0.85rem; color: var(--clr-muted);">This ticket is closed.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
