<?php
require_once '../include/header.php';

unset($_SESSION['user']);

// // On supprime le cookie
// setcookie('remember', '', 1);

if(isset($_SERVER['HTTP_REFERER'])){
    header('Location: '.$_SERVER['HTTP_REFERER']);
}else{
    header('Location: '.URL);
}