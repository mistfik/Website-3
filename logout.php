<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

session_destroy();
header('Location: /login.php');
exit;
?>