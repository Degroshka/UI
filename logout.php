<?php
// Убедимся, что нет никакого вывода перед началом сессии
ob_start();

require_once 'auth/session.php';

// Запускаем сессию в самом начале
Session::start();

// Уничтожаем сессию
Session::destroy();

// Перенаправляем на страницу входа
header("Location: login.php");
exit();
?> 