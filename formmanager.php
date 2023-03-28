<?php

declare(strict_types=1);

require_once("unique.php");
require_once("classes.php");
require_once("database.php");


$exist = 0;
$secondNameError = $firstNameError = $patronymicError = $emailError = $numberError = '';
if (!(isset($_POST["email"]) && isset($_POST["secondName"]) && isset($_POST["firstName"]) && isset($_POST["birthday"])))
{
    return;
}

if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["firstName"]))
{
    $firstNameError = "Введите корректное имя";
}

if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["secondName"]))
{
    $secondNameError = "Введите корректную фамилию";
}

if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["patronymic"]))
{
    $patronymicError = "Введите корректное отчество";
}

$user = '[a-zA-Z0-9_\-\.\+\^!#\$%&*+\/\=\?`\|\{\}~\']+'; 
$domain = '(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.?)+'; 

if (!preg_match("/^$user@$domain$/", $_POST["email"]))
{
    $emailError = "Введите корректный email";
}

if (!preg_match("/^[0-9+]*$/", $_POST["number"]))
{
    $numberError = "Введите корректный номер";
}

if ($secondNameError !== '' || $firstNameError !== '' || $patronymicError !== '' || $emailError !== '' || $numberError !== '')
{
    return;
}

array_pop($_POST);
if (isset($_FILES["avatar"]) && $_FILES && $_FILES["avatar"]["error"] == UPLOAD_ERR_OK) 
    { 
        $countFiles = count(scandir('avatars')) - 1; 
        $extension = pathinfo($_FILES["avatar"]["name"])['extension']; 
        rename($_FILES["avatar"]["tmp_name"], "avatars/{$countFiles}.{$extension}"); 
        $_POST["avatar"] = "avatars/" . $countFiles . "." . $extension; 
    } 
else  
    { 
        $_POST["avatar"] = null; 
    }
$newUser = new User(null, $_POST["firstName"], $_POST["secondName"], $_POST["patronymic"], $_POST["gender"], $_POST["birthday"], $_POST["email"], $_POST["number"], $_POST["avatar"]);
$connection = connectDatabase();
$userId = saveUserToDatabase($connection, $newUser);

if (!$userId)
{
    $exist = 1;
}
else
{
    $exist = 2;
    $redirectUrl = "/show_user.php?user_id=$userId";
    header('Location: ' . $redirectUrl, true, 303);
}
die();