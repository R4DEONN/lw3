<?php

declare(strict_types=1);

namespace App\Database;

use App\Model\User;

class UserTable
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function add(User $user): int|bool
    {
        $query = <<<SQL
            INSERT INTO user (first_name, last_name, middle_name, gender, birth_date, email, phone, avatar_path)
            VALUES (:first_name, :last_name, :middle_name, :gender, :birth_date, :email, :phone, :avatar_path)  
            SQL;
        $statement = $this->connection->prepare($query);
        
        try 
        {
            $statement->execute([   
                ':first_name' => $user->getFirstName(),
                ':last_name' => $user->getLastName(),
                ':middle_name' => $user->getMiddleName(),
                ':gender' => $user->getGender(),
                ':birth_date' => $user->getBirthDate(),
                ':email' => $user->getEmail(),
                ':phone' => $user->getPhone(),
                ':avatar_path' => $user->getAvatarPath()
            ]);  
        } 
        catch (\PDOException $e) 
        {
            echo "DataBase Error: The user could not be added.<br>".$e->getMessage();
            return false;
        } 
        catch (\Exception $e) 
        {
            echo "General Error: The user could not be added.<br>".$e->getMessage();
            return false;
        }
    
    
        return (int)$this->connection->lastInsertId();
    }

    public function find(int $id): User
    {
        $query = <<<SQL
            SELECT *
            FROM user
            WHERE user_id = $id
            SQL;
        $statement = $this->connection->query($query);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$row)
        {
            throw new \RuntimeException("User with id $id could not be found");
        }
        return $this->createUserFromRow($row);
    }

    private function createUserFromRow(array $row): User
    {
        return new User(
            (int)$row['user_id'],
            $row['first_name'], 
            $row['last_name'], 
            $row['middle_name'], 
            $row['gender'], 
            $row['birth_date'], 
            $row['email'], 
            $row['phone'], 
            $row['avatar_path']
        );  
    }

    public function update(int $userId, string $avatar_path): void
    {
        $query = <<<SQL
            UPDATE user
            SET avatar_path = :avatar_path
            WHERE user_id = :userId
            SQL;
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':avatar_path' => $avatar_path,
            ':userId' => $userId
        ]);
    }
}