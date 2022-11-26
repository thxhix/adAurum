<?php
require_once('Class/Database.php');
session_start();

$db = new DB();

if (!isset($_POST['login']) && !isset($_POST['password'])) {
    $result = [
        'status' => 'error',
        'errorCode' => 1,
        'errorText' => 'Произошла ошибка, попробуйте еще раз!'
    ];
    die(json_encode($result, JSON_UNESCAPED_UNICODE));
} else {
    $User = $db->getAll('users', 'WHERE login=:login', ['login' => $_POST['login']]);

    if (!$User) {
        $result = [
            'status' => 'error',
            'errorCode' => 2,
            'errorText' => 'Такого пользователя не существует!'
        ];
        die(json_encode($result, JSON_UNESCAPED_UNICODE));
    } else {
        $login = $_POST['login'];
        $password = $_POST['password'];

        if (!password_verify($password, $User[0]['password'])) {
            $result = [
                'status' => 'error',
                'errorCode' => 3,
                'errorText' => 'Вы ввели неверный пароль!'
            ];
            die(json_encode($result, JSON_UNESCAPED_UNICODE));
        } else {
            $_SESSION['id'] = $User[0]['id'];
            $_SESSION['login'] = $User[0]['login'];
            $_SESSION['is_auth'] = true;

            $result = [
                'status' => 'success',
                'user_id' => $User[0]['id'],
                'login' => $User[0]['login'],
                'hash' => password_hash($User[0]['password'], PASSWORD_DEFAULT)
            ];
            die(json_encode($result, JSON_UNESCAPED_UNICODE));
        }
    }
}
