-- Insert admin user if not exists
INSERT INTO users (username, password, full_name, role, must_change_password)
SELECT 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin', false
WHERE NOT EXISTS (
    SELECT 1 FROM users WHERE username = 'admin'
); 