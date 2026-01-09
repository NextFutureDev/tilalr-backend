-- Create test users with roles
INSERT INTO users (name, email, password, is_admin, created_at, updated_at) VALUES
('Executive Manager', 'executive@example.com', '$2y$12$zl2HJxhSzFVWcWH7m0YhtuSTuNZ8MG7LNQnGz3YtCDI3VqYY/KCz2', 0, NOW(), NOW()),
('Consultant', 'consultant@example.com', '$2y$12$zl2HJxhSzFVWcWH7m0YhtuSTuNZ8MG7LNQnGz3YtCDI3VqYY/KCz2', 0, NOW(), NOW()),
('Administration', 'admin@example.com', '$2y$12$zl2HJxhSzFVWcWH7m0YhtuSTuNZ8MG7LNQnGz3YtCDI3VqYY/KCz2', 0, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Assign roles to users
-- Executive Manager (ID: last_insert_id - 2) gets executive_manager role (ID: 1)
INSERT INTO role_user (user_id, role_id, created_at, updated_at)
SELECT u.id, 1, NOW(), NOW() FROM users u WHERE u.email = 'executive@example.com'
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Consultant (ID: last_insert_id - 1) gets consultant role (ID: 2)
INSERT INTO role_user (user_id, role_id, created_at, updated_at)
SELECT u.id, 2, NOW(), NOW() FROM users u WHERE u.email = 'consultant@example.com'
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Administration (ID: last_insert_id) gets administration role (ID: 3)
INSERT INTO role_user (user_id, role_id, created_at, updated_at)
SELECT u.id, 3, NOW(), NOW() FROM users u WHERE u.email = 'admin@example.com'
ON DUPLICATE KEY UPDATE updated_at = NOW();
