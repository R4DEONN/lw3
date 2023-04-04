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
            $requestData['firstName'], 
            $requestData['secondName'], 
            $requestData['middleName'], 
            $requestData['gender'], 
            $requestData['birthday'], 
            $requestData['email'], 
            $requestData['number'], 
            null
        );
        $userId = $this->userTable->add($user);
        $this->addAvatar($userId, $requestData['avatar']);
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
        $extension = pathinfo($avatar['avatar']['name'], PATHINFO_EXTENSION);
        $dir = __DIR__ . "/../../uploads/avatar$userId.$extension";
        if (!empty($avatar['avatar']) && $avatar['avatar']['error'] == UPLOAD_ERR_OK) 
        { 
            rename($avatar['avatar']['tmp_name'], $dir);
            $this->userTable->update($userId, "avatar$userId.$extension"); 
        }
    }

    private function writeRedirectSeeOther(string $url): void
    {
        header('Location: ' . $url, true, self::HTTP_STATUS_303_SEE_OTHER);
    }
}