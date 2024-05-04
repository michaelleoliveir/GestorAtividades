<?php

session_start();

if(!isset($_SESSION['acesso']) && $_POST['url'] != 'signin-page' && $_POST['url'] != 'login-page') {
    echo 'not session';
    exit();
} elseif (isset($_SESSION['acesso']) && ($_POST['url'] == 'signin-page' || $_POST['url'] == 'login-page')) {
    echo 'session';
    exit();
}
