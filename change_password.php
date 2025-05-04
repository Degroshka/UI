<?php
require_once 'auth/check_auth.php';
require_once 'auth/User.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (strlen($newPassword) < 6) {
        $error = 'Пароль должен быть не менее 6 символов';
    } elseif ($newPassword !== $confirm) {
        $error = 'Пароли не совпадают';
    } else {
        $user = new User();
        $userId = $_SESSION['user_id'];
        $stmt = $user->conn->prepare("UPDATE users SET password=?, must_change_password=FALSE WHERE id=?");
        $stmt->execute([
            password_hash($newPassword, PASSWORD_DEFAULT),
            $userId
        ]);
        $success = 'Пароль успешно изменён!';
        // Можно перенаправить на главную
        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Смена пароля</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Смена пароля</div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Новый пароль</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Повторите пароль</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Сменить пароль</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> 