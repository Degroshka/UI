<?php
require_once 'session.php';

function isAdmin() {
    $role = Session::get('role');
    return $role === 'admin' || $role === 'superuser';
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(['error' => 'Доступ запрещен. Требуются права администратора.']);
        exit;
    }
}

function requireAdminHtml() {
    if (!isAdmin()) {
        header('Location: index.php');
        exit;
    }
} 