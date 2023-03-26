<?php

require_once "database.php";

$userId = (int) $_GET['user_id'];
if (!$userId)
{
    echo "Ошибка запроса";
}

$connection = connectDatabase();
$user = findUserInDatabase($connection, $userId);
if (!$user)
{
    echo "Пользователь не найден";
}

require 'user.php';