<?php
require_once 'auth/check_auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление преподавателями</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Управление преподавателями</h1>
        
        <!-- Add Teacher Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Добавить преподавателя</h5>
            </div>
            <div class="card-body">
                <form id="addTeacherForm">
                    <div class="mb-3">
                        <label for="teacherName" class="form-label">ФИО</label>
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
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>

        <!-- Teachers Table -->
        <div class="card">
            <div class="card-header">
                <h5>Список преподавателей</h5>
            </div>
            <div class="card-body">
                <table class="table" id="teachersTable">
                    <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Кафедра</th>
                            <th>Должность</th>
                            <th>Email</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Teachers will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html> 