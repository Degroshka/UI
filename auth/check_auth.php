<?php
// Убедимся, что нет никакого вывода перед началом сессии
ob_start();

require_once 'session.php';

// Запускаем сессию в самом начале
Session::start();

// Если пользователь не авторизован, перенаправляем на страницу входа
if (!Session::get('user_id')) {
    header("Location: login.php");
    exit();
} 