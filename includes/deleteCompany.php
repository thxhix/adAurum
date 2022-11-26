<?php

require_once('Class/Database.php');

$result = [];

if (isset($_POST['company_id'])) {
    $company = $_POST['company_id'];

    $db = new DB();

    $params = [
        'company' => $company,
    ];

    $db->query('DELETE FROM `company` WHERE id=:company', $params);

    $result = [
        'status' => 'success',
        'company_id' => $company
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
