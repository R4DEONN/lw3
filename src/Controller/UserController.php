<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\ConnectionProvider;
use App\Database\UserTable;
use App\Model\User;

class UserController
{
    private const HTTP_STATUS_303_SEE_OTHER = 303;

    private UserTable $userTable;

    private const USER_ID = "user_id";
    private const EMAIL = "email";
    private const SECOND_NAME = "secondName";
    private const FIRST_NAME = "firstName";
    private const MIDDLE_NAME = "middleName";
    private const BIRTHDAY = "birthday";
    private const NUMBER = "number";
    private const GENDER = "gender";
    private const AVATAR = "avatar";
    private const ERROR = "error";
    private const TMP_NAME = "tmp_name";
    
    public function __construct()
    {
        $connection = ConnectionProvider::connectDatabase();
        $this->userTable = new UserTable($connection);
    }

    public function index(): void
    {
        require __DIR__ . '/../View/index.php';
    }

    public function createUser(array $requestData): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
        {
            $this->writeRedirectSeeOther('/');
            return;
        }

        $user = new User(
            null, 
            $requestData[FIRST_NAME], 
            $requestData[SECOND_NAME],  
            $requestData[MIDDLE_NAME],  
            $requestData[GENDER], 
            $requestData[BIRTHDAY], 
            $requestData[EMAIL],  
            $requestData[NUMBER], 
            null
        );
        $userId = $this->userTable->add($user);
        $this->addAvatar($userId, $requestData[AVATAR]);
        $redirectUrl = "/show_user.php?user_id=$userId";
        $this->writeRedirectSeeOther($redirectUrl);
    }

    public function showUser(array $queryParams): void
    {
        $userId = (int) $queryParams['user_id'];
        if ($userId === 0 || !$userId) 
        {
            throw new \RuntimeException("User with id {$userId} doesn't exist");
        }
        $user = $this->userTable->find($userId);
        require __DIR__ . '/../View/user.php';
    }

    private function addAvatar(int $userId, array $avatar): void
    {
        if (!empty($avatar[AVATAR]) && $avatar[AVATAR][ERROR] == UPLOAD_ERR_OK) 
        {
            $extension = pathinfo($avatar[AVATAR][NAME], PATHINFO_EXTENSION);
            $dir = __DIR__ . "/../../uploads/avatar$userId.$extension"; 
            rename($avatar[AVATAR][TMP_NAME], $dir);
            $this->userTable->update($userId, "avatar$userId.$extension"); 
        }
    }

    private function writeRedirectSeeOther(string $url): void
    {
        header('Location: ' . $url, true, self::HTTP_STATUS_303_SEE_OTHER);
    }
}