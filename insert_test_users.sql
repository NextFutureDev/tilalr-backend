-- Test Users for RBAC System
-- Password: password123 (hashed with bcrypt)
-- Hash: $2y$12$zl2HJxhSzFVWcWH7m0YhtuSTuNZ8MG7LNQnGz3YtCDI3VqYY/KCz2

INSERT INTO users (name, email, password, is_admin, created_at, updated_at) VALUES
('Executive Manager', 'executive@example.com', '$2y$12$zl2HJxhSzFVWcWH7m0YhtuSTuNZ8MG7LNQnGz3YtCDI3VqYY/KCz2', 0, NOW(), NOW()),
('Consultant', 'consultant@example.com', '$2y$12$zl2HJxhSzFVWcWH7m0YhtuSTuNZ8MG7LNQnGz3YtCDI3VqYY/KCz2', 0, NOW(), NOW()),
('Administration', 'admin@example.com', '$2y$12$zl2HJxhSzFVWcWH7m0YhtuSTuNZ8MG7LNQnGz3YtCDI3VqYY/KCz2', 0, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Get user IDs and assign roles
INSERT INTO role_user (user_id, role_id, created_at, updated_at)
SELECT u.id, 1, NOW(), NOW() FROM users u WHERE u.email = 'executive@example.com'
ON DUPLICATE KEY UPDATE updated_at = NOW();

INSERT INTO role_user (user_id, role_id, created_at, updated_at)
SELECT u.id, 2, NOW(), NOW() FROM users u WHERE u.email = 'consultant@example.com'
ON DUPLICATE KEY UPDATE updated_at = NOW();

INSERT INTO role_user (user_id, role_id, created_at, updated_at)
SELECT u.id, 3, NOW(), NOW() FROM users u WHERE u.email = 'admin@example.com'
ON DUPLICATE KEY UPDATE updated_at = NOW();
