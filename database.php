<?php

declare(strict_types=1);

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

function saveUserToDatabase(PDO $connection, array $userParams): int
{
    $query = <<<SQL
        INSERT INTO user (first_name, last_name, middle_name, gender, birth_date, email, phone, avatar_path)
        VALUES (:first_name, :last_name, :middle_name, :gender, :birth_date, :email, :phone, :avatar_path)  
        SQL;
    $statement = $connection->prepare($query);
    
    try 
    {
        $statement->execute([   
            ':first_name' => $userParams['first_name'],
            ':last_name' => $userParams['last_name'],
            ':middle_name' => $userParams['middle_name'],
            ':gender' => $userParams['gender'],
            ':birth_date' => $userParams['birth_date'],
            ':email' => $userParams['email'],
            ':phone' => $userParams['phone'],
            ':avatar_path' => $userParams['avatar_path']
        ]);  
    } 
    catch (PDOException $e) 
    {
        echo "DataBase Error: The user could not be added.<br>".$e->getMessage();
        return 0;
    } 
    catch (Exception $e) 
    {
        echo "General Error: The user could not be added.<br>".$e->getMessage();
        return 0;
    }


    return (int)$connection->lastInsertId();
}

function findUserInDatabase(PDO $pdo, int $userId): ?array
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
    return $row ?: null;
}
