<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if (!(isset($_POST[EMAIL]) && isset($_POST[SECOND_NAME]) && isset($_POST[FIRST_NAME]) && isset($_POST[BIRTHDAY])))
{
    return;
}

array_pop($_POST);
$avatar_path = null;
if (isset($_FILES[AVATAR]) && $_FILES && $_FILES[AVATAR]["error"] == UPLOAD_ERR_OK) 
    { 
        $countFiles = count(scandir(AVATAR)) - 1; 
        $extension = pathinfo($_FILES["avatar"]["name"])['extension']; 
        rename($_FILES[AVATAR]["tmp_name"], "avatars/{$countFiles}.{$extension}"); 
        $avatar_path = "avatars/" . $countFiles . "." . $extension; 
    }
$requestData = array(FIRST_NAME => $_POST[FIRST_NAME], SECOND_NAME => $_POST[SECOND_NAME], MIDDLE_NAME => $_POST[MIDDLE_NAME], GENDER => $_POST[GENDER], BIRTHDAY => $_POST[BIRTHDAY], EMAIL => $_POST[EMAIL], NUMBER => $_POST[NUMBER], AVATAR => $avatar_path);

$controller = new App\Controller\UserController();
$controller->createUser($requestData);