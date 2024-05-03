<?php
class utility
{
    public static function connectionDatabase()
    {
        // universal code for connecting to DB, if there is problem it throws conn err
        $servername = "localhost"; // localhost or 127.0.0.1
        $username = "root"; //root by default
        $password = ""; // nothing by default
        $tableName = "eshop"; // depends on my table
        $conn = new mysqli($servername, $username, $password, $tableName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    public static function calculatePrice($price, $sale) {

        $finalNumber = $price * ($sale / 100);
        $finalNumber = round($price - $finalNumber) . " Kč";
        $finalNumberFloat = (float)$finalNumber;

        return $finalNumberFloat;

    }
}
