<?php

require_once('Class/Database.php');

$result = [];

if (isset($_POST['company'])) {

    $data = $_POST['company'];

    $db = new DB();

    $params = [
        'name' => htmlentities($data['name']),
        'address' => htmlentities($data['address']),
        'phone' => htmlentities($data['phone']),
        'ceo' => htmlentities($data['ceo']),
        'inn' => htmlentities($data['inn']),
        'detail' => htmlentities($data['detail'])
    ];

    $id = $db->insertQuery('INSERT INTO `company`(`id`, `name`, `address`, `phone`, `ceo`, `inn`, `detail`) VALUES (0, :name, :address, :phone, :ceo, :inn, :detail)', $params);

    $result = [
        'status' => 'success',
        'new_id' => $id,
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
