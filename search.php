<?php
require_once 'auth/check_auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск - Система управления расписанием</title>
    <link rel="stylesheet" href="css/styles.css">
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
                        <a class="nav-link" href="groups.php">Группы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="schedule.php">Расписание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="teachers.php">Преподаватели</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="search.php">Поиск</a>
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
        <h2 class="mb-4">Поиск</h2>
        <form id="searchForm" class="mb-4">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <select class="form-select" id="searchSubject">
                        <option value="">Предмет</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select class="form-select" id="searchTeacher">
                        <option value="">Преподаватель</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select class="form-select" id="searchGroup">
                        <option value="">Группа</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select class="form-select" id="searchType">
                        <option value="">Тип занятия</option>
                        <option value="lecture">Лекция</option>
                        <option value="practice">Практика</option>
                        <option value="lab">Лабораторная</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <input type="date" class="form-control" id="searchDateFrom" placeholder="Дата от">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="date" class="form-control" id="searchDateTo" placeholder="Дата до">
                </div>
                <div class="col-md-3 mb-2">
                    <select class="form-select" id="searchTimeInterval">
                        <option value="">Время занятия</option>
                        <option value="8:30-10:00">8:30-10:00</option>
                        <option value="10:15-11:45">10:15-11:45</option>
                        <option value="12:00-13:30">12:00-13:30</option>
                        <option value="14:00-15:30">14:00-15:30</option>
                        <option value="15:45-17:15">15:45-17:15</option>
                        <option value="17:30-19:00">17:30-19:00</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-primary w-100">Найти</button>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-header">
                <h5>Результаты поиска</h5>
            </div>
            <div class="card-body">
                <table class="table" id="searchResultsTable">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Предмет</th>
                            <th>Преподаватель</th>
                            <th>Группа</th>
                            <th>Аудитория</th>
                            <th>Тип</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Результаты поиска -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html> 