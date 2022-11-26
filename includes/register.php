<?php

require_once('Class/Database.php');

$db = new DB();

$result = [];

if (!isset($_POST['login']) && !isset($_POST['password']) && !isset($_POST['retry_password'])) {
    $result = [
        'status' => 'error',
        'errorCode' => 4,
        'errorText' => 'Произошла ошибка, попробуйте еще раз!'
    ];
    die(json_encode($result, JSON_UNESCAPED_UNICODE));
} else {
    $login = htmlentities(trim($_POST['login']));
    $pass = $_POST['password'];
    $pass_retry = $_POST['retry_password'];

    if ($pass !== $pass_retry) {
        $result = [
            'status' => 'error',
            'errorCode' => 1,
            'errorText' => 'Пароли не совпадают!'
        ];
        die(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    if (mb_strlen($login) < 3 || mb_strlen($login) > 15) {
        $result = [
            'status' => 'error',
            'errorCode' => 2,
            'errorText' => 'Логин не подходит! Минимум - 3 символа, максимум - 15'
        ];
        die(json_encode($result, JSON_UNESCAPED_UNICODE));
    }


    if ($db->getAll('users', 'WHERE login = :login', ['login' => $_POST['login']])) {
        $result = [
            'status' => 'error',
            'errorCode' => 3,
            'errorText' => 'Такой логин уже существует!'
        ];
        die(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    registerUser($db);

    $result = [
        'status' => 'success'
    ];
    die(json_encode($result, JSON_UNESCAPED_UNICODE));
}

function registerUser($db)
{
    $login = $_POST['login'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $params = [
        'id' => 0,
        'log' => $login,
        'pass' => $pass
    ];

    return $db->query('INSERT INTO `users` (`id`, `login`, `password`) VALUES (:id, :log, :pass)', $params);
}
