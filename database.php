<?php

declare(strict_types=1);

require_once("classes.php");

/**
* @return array{dsn:string,username:string,password:string}
*/
function getConnectionParams(): array
{
    $stringParams = file_get_contents("configuration.json");
    $arrayParams = json_decode($stringParams, true);
    return $arrayParams;
}

function connectDatabase(): PDO
{
    $connectionParams = getConnectionParams();
    $dsn = $connectionParams['dsn'];
    $user = $connectionParams['user'];
    $password = $connectionParams['password'];
    return new PDO($dsn, $user, $password);
}

function saveUserToDatabase(PDO $connection, User $user): int|bool
{
    $query = <<<SQL
        INSERT INTO user (first_name, last_name, middle_name, gender, birth_date, email, phone, avatar_path)
        VALUES (:first_name, :last_name, :middle_name, :gender, :birth_date, :email, :phone, :avatar_path)  
        SQL;
    $statement = $connection->prepare($query);
    
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
    catch (PDOException $e) 
    {
        echo "DataBase Error: The user could not be added.<br>".$e->getMessage();
        return false;
    } 
    catch (Exception $e) 
    {
        echo "General Error: The user could not be added.<br>".$e->getMessage();
        return false;
    }


    return (int)$connection->lastInsertId();
}

function findUserInDatabase(PDO $pdo, int $userId): ?User
{
    // Извлекает пользователя с заданным ID из базы данных
    //  с помощью SELECT.
    // Возвращает ассоциативный массив либо null, если
    //  пользователь не найден
    $query = <<<SQL
        SELECT *
        FROM user
        WHERE user_id = $userId
        SQL;
    $statement = $pdo->query($query);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row)
    {
        throw new RuntimeException("User with id $userId could not be found");
    }
    $user = new User($row['user_id'], $row['first_name'], $row['last_name'], $row['middle_name'], $row['gender'], $row['birth_date'], $row['email'], $row['phone'], $row['avatar_path']);  
    return $user ?: null;
}
