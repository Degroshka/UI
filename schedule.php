<?php
require_once 'auth/check_auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Расписание</h1>
        
        <!-- Add Schedule Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Добавить занятие</h5>
            </div>
            <div class="card-body">
                <form id="addScheduleForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label">Предмет</label>
                            <select class="form-select" id="subject" required>
                                <!-- Subjects will be loaded here -->
                            </select>
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
                            <label for="startTime" class="form-label">Время начала</label>
                            <input type="time" class="form-control" id="startTime" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="endTime" class="form-label">Время окончания</label>
                            <input type="time" class="form-control" id="endTime" required>
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
                            <th>Действия</th>
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
    <script src="js/main.js"></script>
</body>
</html> 