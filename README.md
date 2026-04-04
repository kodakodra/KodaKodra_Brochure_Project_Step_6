# KodaKodra — Step 6: Support Ticket System

## What This Is
A full support ticket system built on top of the existing auth and database layers. Users can open tickets, reply to them, and track their status. Admins can view all tickets across all users and participate in any thread.

## What This Demonstrates
- Relational data — tickets and replies linked via foreign keys
- Threaded reply system with oldest-first ordering
- Ticket lifecycle — open, pending (awaiting user), closed
- Status auto-update on reply — admin reply sets pending, user reply sets open
- Role-based access — users see only their own tickets, admins see all
- Ownership checks on reply and close actions — no unauthorized access
- Database transactions — ticket and first reply created atomically
- Admin panel for tickets separate from admin submissions panel
- Dashboard updated with live ticket counts per status

## File Structure
```
/
├── includes/
│   ├── config.php          — Site constants, DB and mail settings
│   ├── db.php              — PDO database connection
│   ├── auth.php            — Login guard
│   ├── admin-auth.php      — Admin role guard
│   ├── header.php          — Reusable header, session-aware navbar
│   └── footer.php          — Reusable footer and script tags
├── vendor/                 — PHPMailer installed via Composer
├── migration.sql           — Run to add tickets and ticket_replies tables
├── index.php               — Home page
├── about.php               — About page
├── services.php            — Services page
├── contact.php             — Contact page with form
├── contact-handler.php     — Form processing, DB insert, PHPMailer
├── register.php            — Registration form and handler
├── login.php               — Login form and handler
├── logout.php              — Destroys session and redirects
├── dashboard.php           — User dashboard with submission and ticket summary
├── tickets.php             — User ticket list and new ticket form
├── ticket.php              — Single ticket thread with reply form
├── ticket-handler.php      — Handles create, reply, and close actions
├── admin.php               — Admin panel — all submissions
├── admin-tickets.php       — Admin panel — all tickets
├── style.css               — All custom styles
└── script.js               — Form validation and fetch submission
```

## Setup
1. Run `migration.sql` to add the tickets and ticket_replies tables
2. Promote a user to admin to access the admin panels:
   `UPDATE users SET role = 'admin' WHERE email = 'your@email.com';`

## Tech Used
- HTML5
- CSS3 (style.css)
- JavaScript (script.js)
- Bootstrap 5
- Font Awesome 6
- PHP
- PHPMailer
- MySQL
- PDO

## Notes
- Tickets require a logged-in user — guests cannot open tickets
- Closed tickets cannot receive new replies
- Ticket and first reply are inserted in a transaction — both succeed or neither does
- Admin replies set status to pending, user replies set status back to open
- Admins can view and reply to any ticket regardless of ownership
