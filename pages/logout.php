<?php
if (!isset($_SESSION)) {
    session_start();
    session_destroy();
    $_SESSION = null;
    header('Location: http://multiplygame.as/pages/login.php');
    exit();
}