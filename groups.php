<?php
require_once 'auth/check_auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление группами - Система управления расписанием</title>
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
                        <a class="nav-link active" href="groups.php">Группы</a>
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
        <h2 class="mb-4">Управление группами</h2>
        
        <!-- Add Group Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Добавить новую группу</h5>
                <form id="addGroupForm">
                    <div class="mb-3">
                        <label for="groupName" class="form-label">Название группы</label>
                        <input type="text" class="form-control" id="groupName" required>
                    </div>
                    <div class="mb-3">
                        <label for="groupDescription" class="form-label">Описание</label>
                        <textarea class="form-control" id="groupDescription" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить группу</button>
                </form>
            </div>
        </div>

        <!-- Groups Table -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Список групп</h5>
                <div class="table-responsive">
                    <table class="table" id="groupsTable">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Groups will be loaded here via JavaScript -->
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