<?php
class DBconnect
{
    public static function connectDatabase()
    {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $tableName = "eshop";
        $conn = new mysqli($servername, $username, $password, $tableName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}