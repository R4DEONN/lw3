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
            $requestData['avatar']
        );
        $userId = $this->userTable->add($user);
        $redirectUrl = "/show_user.php?user_id=$userId";
        $this->writeRedirectSeeOther($redirectUrl);
    }

    public function showUser(array $queryParams): void
    {
        $userId = (int) $_GET['user_id'];
        if ($userId === 0 || !$userId) 
        {
            throw new \RuntimeException("User with id {$userId} doesn't exist");
        }
        $user = $this->userTable->find($userId);
        require __DIR__ . '/../View/user.php';
    }

    private function writeRedirectSeeOther(string $url): void
    {
        header('Location: ' . $url, true, self::HTTP_STATUS_303_SEE_OTHER);
    }
}