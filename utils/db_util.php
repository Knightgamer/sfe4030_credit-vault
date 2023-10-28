<?php

function connectDatabase()
{
    require './database.php';

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

