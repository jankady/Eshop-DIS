<?php

class Product_card
{
    public function product()
    {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $tableName = "eshop";
        $conn = new mysqli($servername, $username, $password, $tableName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->ping();
        $sql = "SELECT name FROM category";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li><a class="dropdown-item" href="#">'.$row["name"].'</a></li>';
        }
        mysqli_close($conn);
    }
}

?>
