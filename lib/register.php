<?php
session_start();

include('db.php');

// Регистрация
insertDBUser('users', $_POST['username'], $_POST['password']);

header("Location: /index.php?page=page-result&message=Регистрация прошла успешно!");

exit();
