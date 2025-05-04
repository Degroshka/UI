<?php
require_once 'auth/check_auth.php';
require_once 'auth/permissions.php';

$isAdmin = isAdmin();
// Отладочная информация
error_log("User role: " . Session::get('role'));
error_log("Is admin: " . ($isAdmin ? 'true' : 'false'));
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система управления расписанием</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <script>
        // Глобальная переменная для JavaScript
        const isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
        console.log('isAdmin:', isAdmin);
    </script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Расписание</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="groups.php">Группы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="schedule.php">Расписание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="teachers.php">Преподаватели</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search.php">Поиск</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Вы вошли как: <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Выйти</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Добро пожаловать в систему управления расписанием</h1>
                <p class="text-center">Вы вошли как: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p class="text-center">Ваша роль: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Группы</h5>
                        <p class="card-text"><?php echo $isAdmin ? 'Управление учебными группами' : 'Просмотр списка групп'; ?></p>
                        <a href="groups.php" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Расписание</h5>
                        <p class="card-text">Просмотр расписания</p>
                        <a href="schedule.php" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Преподаватели</h5>
                        <p class="card-text"><?php echo $isAdmin ? 'Управление списком преподавателей' : 'Просмотр списка преподавателей'; ?></p>
                        <a href="teachers.php" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html> 