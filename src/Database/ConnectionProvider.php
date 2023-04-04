<?php

declare(strict_types=1);

namespace App\Database;

class ConnectionProvider
{
    /**
    * @return array{dsn:string,username:string,password:string}
    */
    private function getConnectionParams(): array
    {
        $stringParams = file_get_contents(__DIR__ . "/configuration.json");
        $arrayParams = json_decode($stringParams, true);
        return $arrayParams;
    }

    public static function connectDatabase(): \PDO
    {
        $connectionParams = (new ConnectionProvider)->getConnectionParams();
        $dsn = $connectionParams['dsn'];
        $user = $connectionParams['user'];
        $password = $connectionParams['password'];
        return new \PDO($dsn, $user, $password);
    }
}