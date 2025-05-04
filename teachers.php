<?php
require_once 'auth/check_auth.php';
require_once 'auth/permissions.php';

$isAdmin = isAdmin();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Преподаватели - Система управления расписанием</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <script>
        // Глобальная переменная для JavaScript
        const isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
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
                        <a class="nav-link active" href="teachers.php">Преподаватели</a>
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
        <h1><?php echo $isAdmin ? 'Управление преподавателями' : 'Список преподавателей'; ?></h1>
        
        <?php if ($isAdmin): ?>
        <!-- Add Teacher Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Добавить нового преподавателя</h5>
                <form id="addTeacherForm">
                    <div class="mb-3">
                        <label for="teacherName" class="form-label">ФИО преподавателя</label>
                        <input type="text" class="form-control" id="teacherName" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Кафедра</label>
                        <input type="text" class="form-control" id="department">
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Должность</label>
                        <input type="text" class="form-control" id="position">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить преподавателя</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Teachers Table -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Список преподавателей</h5>
                <div class="table-responsive">
                    <table class="table" id="teachersTable">
                        <thead>
                            <tr>
                                <th>ФИО</th>
                                <th>Кафедра</th>
                                <th>Должность</th>
                                <th>Email</th>
                                <?php if ($isAdmin): ?>
                                <th>Действия</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Teachers will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html> 