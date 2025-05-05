<?php
require_once 'auth/check_auth.php';
require_once 'auth/permissions.php';

// Проверка прав администратора для редактирования
$isAdmin = isAdmin();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание - Система управления расписанием</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Расписание</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'groups.php' ? ' active' : '' ?>" href="groups.php">Группы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'schedule.php' ? ' active' : '' ?>" href="schedule.php">Расписание</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'teachers.php' ? ' active' : '' ?>" href="teachers.php">Преподаватели</a>
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
        <h1><?php echo $isAdmin ? 'Управление расписанием' : 'Расписание занятий'; ?></h1>
        
        <?php if ($isAdmin): ?>
        <!-- Форма добавления занятия (только для администраторов) -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Добавить занятие</h5>
            </div>
            <div class="card-body">
                <form id="addScheduleForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label">Предмет</label>
                            <input type="text" class="form-control" id="subject" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="teacher" class="form-label">Преподаватель</label>
                            <select class="form-select" id="teacher" required>
                                <!-- Teachers will be loaded here -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="group" class="form-label">Группа</label>
                            <select class="form-select" id="group" required>
                                <!-- Groups will be loaded here -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="room" class="form-label">Аудитория</label>
                            <input type="text" class="form-control" id="room" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label">Дата</label>
                            <input type="date" class="form-control" id="date" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="timeInterval" class="form-label">Время занятия</label>
                            <select class="form-select" id="timeInterval" required>
                                <option value="8:30-10:00">8:30-10:00</option>
                                <option value="10:15-11:45">10:15-11:45</option>
                                <option value="12:00-13:30">12:00-13:30</option>
                                <option value="14:00-15:30">14:00-15:30</option>
                                <option value="15:45-17:15">15:45-17:15</option>
                                <option value="17:30-19:00">17:30-19:00</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Тип занятия</label>
                        <select class="form-select" id="type" required>
                            <option value="lecture">Лекция</option>
                            <option value="practice">Практика</option>
                            <option value="lab">Лабораторная</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Schedule Table -->
        <div class="card">
            <div class="card-header">
                <h5>Расписание занятий</h5>
            </div>
            <div class="card-body">
                <table class="table" id="scheduleTable">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Предмет</th>
                            <th>Преподаватель</th>
                            <th>Группа</th>
                            <th>Аудитория</th>
                            <th>Тип</th>
                            <?php if ($isAdmin): ?>
                            <th>Действия</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Schedule entries will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Глобальная переменная для JavaScript
        const isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
    </script>
    <script src="js/main.js"></script>
</body>
</html> 