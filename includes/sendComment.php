<?php

require_once('Class/Database.php');

$result = [];

if (isset($_POST['user_id']) && isset($_POST['user_login']) && isset($_POST['company_id']) && isset($_POST['for']) && isset($_POST['text'])) {

    $user = $_POST['user_id'];
    $userLogin = $_POST['user_login'];

    $company = $_POST['company_id'];
    $for = $_POST['for'];
    $text = $_POST['text'];

    $db = new DB();

    $params = [
        'user' => $user,
        'user_login' => $userLogin,
        'company' => $company,
        'field' => $for,
        'pub_date' => date("Y-m-d H:i:s"),
        'text' => htmlentities($text)
    ];



    $db->query('INSERT INTO `comments`(`id`, `from_user`, `from_user_login`, `to_company`, `for_field`, `date`, `text`) VALUES (0, :user, :user_login, :company, :field, :pub_date, :text)', $params);

    $result = [
        'status' => 'success',
        'user' => $user,
        'user_login' => $userLogin,
        'pub_date' => date("Y-m-d H:i:s"),
        'text' => $text
    ];
    die(json_encode($result, JSON_UNESCAPED_UNICODE));
} else {
    $result = [
        'status' => 'error',
        'errorCode' => 1,
        'errorText' => 'Произошла ошибка, попробуйте позже!'
    ];
    die(json_encode($result, JSON_UNESCAPED_UNICODE));
}
