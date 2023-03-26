<?php

require_once("unique.php");
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
$connection = connectDatabase();
$newUserId = saveUserToDatabase($connection, [
    'first_name' => $_POST["firstName"],
    'last_name' => $_POST["secondName"],
    'middle_name' => $_POST["patronymic"],
    'gender' => $_POST["gender"],
    'birth_date' => $_POST["birthday"],
    'email' => $_POST["email"],
    'phone' => $_POST["number"],
    'avatar_path' => $_POST["avatar"]
]);
echo $newUserId;