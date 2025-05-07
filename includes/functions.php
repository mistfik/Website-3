<?php
function cleanInput($data) {
    return htmlspecialchars(trim($data));
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

function validatePhone($phone) {
    return preg_match('/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/', $phone);
}

function validateUsername($username) {
    return preg_match('/^[а-яА-ЯёЁ]{6,}$/u', $username);
}

function validateFullName($full_name) {
    return preg_match('/^[а-яА-ЯёЁ\s]+$/u', $full_name);
}
?>