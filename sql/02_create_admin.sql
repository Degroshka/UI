-- Insert default admin user
INSERT INTO users (username, password, role, full_name, must_change_password)
VALUES (
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin',
    'Administrator',
    FALSE
)
ON CONFLICT (username) DO NOTHING; 