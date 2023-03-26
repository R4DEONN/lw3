<?php

function UniqueUser(array $json, $email, $number): bool 
{
    foreach ($json as $user)
    {
        if (!empty($user["email"]))
        {
            $jsonEmail = $user["email"];
        }
        if (!empty($user["number"]))
        {
            $jsonNumber = $user["number"];
        }
        if (!empty($jsonEmail) && !empty($jsonNumber) && ($jsonEmail === $email || $jsonNumber === $number ))
        {
            return false;
        }
    }
    return true;
}

