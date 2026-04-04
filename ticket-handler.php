<?php global $pdo;

/**
 * ticket-handler.php
 *
 * Handles two actions, determined by the 'action' POST field:
 *
 *   create — opens a new ticket and stores the first reply
 *   reply  — adds a reply to an existing ticket
 *   close  — marks a ticket as closed (owner or admin only)
 *
 * Redirects back to the relevant page on completion.
 * Not visited directly — always called via a form POST.
 */

require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tickets.php');
    exit;
}

$action = trim($_POST['action'] ?? '');

/* ===========================
   Action: Create Ticket
=========================== */

if ($action === 'create') {

    $subject = trim(strip_tags($_POST['subject'] ?? ''));
    $message = trim(strip_tags($_POST['message'] ?? ''));

    // Validate
    if (empty($subject) || strlen($subject) > 150) {
        header('Location: tickets.php?error=invalid_subject');
        exit;
    }

    if (empty($message)) {
        header('Location: tickets.php?error=invalid_message');
        exit;
    }

    try {
        // Begin a transaction — both inserts must succeed or neither does
        $pdo->beginTransaction();

        // Insert the ticket
        $stmt = $pdo->prepare('
            INSERT INTO tickets (user_id, subject)
            VALUES (?, ?)
        ');
        $stmt->execute([$_SESSION['user_id'], $subject]);

        // Get the ID of the ticket we just created
        $ticketId = $pdo->lastInsertId();

        // Insert the opening message as the first reply
        $stmt = $pdo->prepare('
            INSERT INTO ticket_replies (ticket_id, user_id, message)
            VALUES (?, ?, ?)
        ');
        $stmt->execute([$ticketId, $_SESSION['user_id'], $message]);

        $pdo->commit();

        // Redirect to the new ticket
        header('Location: ticket.php?id=' . $ticketId);
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log('Ticket create failed: ' . $e->getMessage());
        header('Location: tickets.php?error=server');
        exit;
    }
}

/* ===========================
   Action: Reply to Ticket
=========================== */

if ($action === 'reply') {

    $ticketId = (int) ($_POST['ticket_id'] ?? 0);
    $message  = trim(strip_tags($_POST['message'] ?? ''));

    if (!$ticketId || empty($message)) {
        header('Location: tickets.php?error=invalid_reply');
        exit;
    }

    // Fetch the ticket — make sure it exists and belongs to this user or they are admin
    $stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = ?');
    $stmt->execute([$ticketId]);
    $ticket = $stmt->fetch();

    if (!$ticket) {
        header('Location: tickets.php?error=not_found');
        exit;
    }

    // Only the ticket owner or an admin can reply
    if ($ticket['user_id'] !== $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin') {
        header('Location: tickets.php?error=unauthorised');
        exit;
    }

    // Closed tickets cannot receive replies
    if ($ticket['status'] === 'closed') {
        header('Location: ticket.php?id=' . $ticketId . '&error=closed');
        exit;
    }

    try {
        // Insert the reply
        $stmt = $pdo->prepare('
            INSERT INTO ticket_replies (ticket_id, user_id, message)
            VALUES (?, ?, ?)
        ');
        $stmt->execute([$ticketId, $_SESSION['user_id'], $message]);

        // If an admin replied, set status to pending (awaiting user response)
        // If the user replied, set status back to open
        $newStatus = $_SESSION['user_role'] === 'admin' ? 'pending' : 'open';

        $stmt = $pdo->prepare('UPDATE tickets SET status = ? WHERE id = ?');
        $stmt->execute([$newStatus, $ticketId]);

        header('Location: ticket.php?id=' . $ticketId);
        exit;

    } catch (PDOException $e) {
        error_log('Ticket reply failed: ' . $e->getMessage());
        header('Location: ticket.php?id=' . $ticketId . '&error=server');
        exit;
    }
}

/* ===========================
   Action: Close Ticket
=========================== */

if ($action === 'close') {

    $ticketId = (int) ($_POST['ticket_id'] ?? 0);

    if (!$ticketId) {
        header('Location: tickets.php');
        exit;
    }

    // Fetch the ticket
    $stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = ?');
    $stmt->execute([$ticketId]);
    $ticket = $stmt->fetch();

    if (!$ticket) {
        header('Location: tickets.php?error=not_found');
        exit;
    }

    // Only the ticket owner or an admin can close the ticket
    if ($ticket['user_id'] !== $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin') {
        header('Location: tickets.php?error=unauthorised');
        exit;
    }

    try {
        $stmt = $pdo->prepare('UPDATE tickets SET status = ? WHERE id = ?');
        $stmt->execute(['closed', $ticketId]);

        header('Location: ticket.php?id=' . $ticketId);
        exit;

    } catch (PDOException $e) {
        error_log('Ticket close failed: ' . $e->getMessage());
        header('Location: ticket.php?id=' . $ticketId . '&error=server');
        exit;
    }
}

// Unknown action — redirect safely
header('Location: tickets.php');
exit;
