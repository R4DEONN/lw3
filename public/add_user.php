<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if (!(isset($_POST[EMAIL]) && isset($_POST[SECOND_NAME]) && isset($_POST[FIRST_NAME]) && isset($_POST[BIRTHDAY])))
{
    return;
}

if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST[FIRST_NAME]))
{
    $errors['firstNameError'] = "Введите корректное имя";
}

if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST[SECOND_NAME]))
{
    $errors['secondNameError'] = "Введите корректную фамилию";
}

if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST[MIDDLE_NAME]))
{
    $errors['middleNameError'] = "Введите корректное отчество";
}

$user = '[a-zA-Z0-9_\-\.\+\^!#\$%&*+\/\=\?`\|\{\}~\']+'; 
$domain = '(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.?)+'; 

if (!preg_match("/^$user@$domain$/", $_POST[EMAIL]))
{
    $errors['emailError'] = "Введите корректный email";
}

if (!preg_match("/^[0-9+]*$/", $_POST[NUMBER]))
{
    $errors['numberError'] = "Введите корректный номер";
}

if (!empty($_FILES[AVATAR]['name']) && $_FILES[AVATAR]['type'] !== 'image/png' && $_FILES[AVATAR]['type'] !== 'image/jpeg' && $_FILES[AVATAR]['type'] !== 'image/gif')
{
    $errors['avatarError'] = "Можно загружать только png, gif, jpeg";
}

if (!empty($errors))
{
    return;
}

array_pop($_POST);
$requestData = array(FIRST_NAME => $_POST[FIRST_NAME], SECOND_NAME => $_POST[SECOND_NAME], MIDDLE_NAME => $_POST[MIDDLE_NAME], GENDER => $_POST[GENDER], BIRTHDAY => $_POST[BIRTHDAY], EMAIL => $_POST[EMAIL], NUMBER => $_POST[NUMBER], AVATAR => $_FILES);

$controller = new App\Controller\UserController();
$controller->createUser($requestData);