<?php

if (!isset($_SESSION)) {
    session_start();
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && empty($_SESSION['user'])) {
    header('Location: http://multiplygame.as/pages/login.php');
    exit();
}

require_once 'functions/helper.php';
