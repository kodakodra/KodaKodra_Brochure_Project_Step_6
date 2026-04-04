-- migration.sql
--
-- Creates the users table for the KodaKodra portfolio site.
-- Run this once against your MySQL database to set up the schema.
-- Example: mysql -u root -p kodakodra < migration.sql

-- Create the database if it doesn't exist yet
CREATE DATABASE IF NOT EXISTS kodakodra CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE kodakodra;

-- ===========================
-- Users Table
-- ===========================
-- Stores registered user accounts.
-- Passwords are stored as bcrypt hashes — never plain text.
-- Role defaults to 'user' — can be promoted to 'admin' manually.

CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED    NOT NULL AUTO_INCREMENT,  -- Unique ID for each user
    name       VARCHAR(100)    NOT NULL,                 -- Display name
    email      VARCHAR(150)    NOT NULL UNIQUE,          -- Login email, must be unique
    password   VARCHAR(255)    NOT NULL,                 -- Bcrypt hashed password
    role       ENUM('user','admin') NOT NULL DEFAULT 'user', -- Access level
    created_at TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Registration date
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Step 5 — adds the submissions table.
-- Run this against your existing kodakodra database.
-- The users table from Step 4 must already exist.

-- ===========================
-- Submissions Table
-- ===========================
-- Stores contact form submissions.
-- user_id is nullable — a guest (not logged in) can still submit the form,
-- but if a user is logged in their ID is recorded against the submission.

CREATE TABLE IF NOT EXISTS submissions (
    id         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    user_id    INT UNSIGNED    NULL,                              -- NULL if submitted as a guest
    name       VARCHAR(100)    NOT NULL,                          -- Submitter's name
    email      VARCHAR(150)    NOT NULL,                          -- Submitter's email
    message    TEXT            NOT NULL,                          -- Message body
    created_at TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Submission date
    PRIMARY KEY (id),

    -- Foreign key links to the users table — SET NULL if the user is deleted
    CONSTRAINT fk_submissions_user
        FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Step 6 — adds the tickets and ticket_replies tables.
-- Run this against your existing kodakodra database.
-- The users table from Step 4 must already exist.

-- ===========================
-- Tickets Table
-- ===========================
-- Each ticket belongs to a registered user.
-- Status tracks where the ticket is in its lifecycle.
-- Subject is a short summary, the opening message is the first reply.

CREATE TABLE IF NOT EXISTS tickets (
    id         INT UNSIGNED         NOT NULL AUTO_INCREMENT,
    user_id    INT UNSIGNED         NOT NULL,                          -- The user who opened the ticket
    subject    VARCHAR(150)         NOT NULL,                          -- Short summary of the issue
    status     ENUM('open','pending','closed') NOT NULL DEFAULT 'open', -- Current ticket status
    created_at TIMESTAMP            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),

    -- Foreign key — if the user is deleted, their tickets are also deleted
    CONSTRAINT fk_tickets_user
        FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ===========================
-- Ticket Replies Table
-- ===========================
-- Each reply belongs to a ticket and a user (either the ticket owner or an admin).
-- The opening message when a ticket is created is stored here as the first reply.

CREATE TABLE IF NOT EXISTS ticket_replies (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    ticket_id  INT UNSIGNED NOT NULL,                          -- The ticket this reply belongs to
    user_id    INT UNSIGNED NOT NULL,                          -- The user who wrote this reply
    message    TEXT         NOT NULL,                          -- Reply content
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),

    -- Foreign key — delete replies if the ticket is deleted
    CONSTRAINT fk_replies_ticket
        FOREIGN KEY (ticket_id) REFERENCES tickets (id)
        ON DELETE CASCADE,

    -- Foreign key — if the user is deleted, keep the reply but set user to NULL
    CONSTRAINT fk_replies_user
        FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
