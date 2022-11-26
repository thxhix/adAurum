<?php

require_once('Database.php');
session_start();

if ($_SESSION && ($_SESSION['id'] && $_SESSION['login'])) {
    $User = new User($_SESSION['id'], $_SESSION['login']);
} else {
    $User = new User(-1, '');
}

// Для выхода из учетки через Ajax
if ($_POST && ($_POST['type'] == 'logout')) {
    die($User->logout());
}

class User
{
    private $id;
    private $login;
    private $db;

    public function __construct($id, $login)
    {
        $this->id = $id;
        $this->login = $login;
        $this->db = new DB();
    }

    public function logout()
    {
        unset($_SESSION);
        session_unset();
        $result = [
            'status' => 'success',
        ];
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function is_Auth()
    {
        if ($this->id && $this->login) {
            return true;
        } else {
            return false;
        }
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getId()
    {
        return $this->id;
    }
}
