<?php
 class DBconnect {
    public function connectDB($tableName)
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $conn = new mysqli($servername,$username,$password,$tableName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);

        }
        else {
            return $conn;
        }
    }



 }