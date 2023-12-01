<?php

class Nav_category
{
    public function nav()
    {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $tableName = "eshop";
        $conn = new mysqli($servername, $username, $password, $tableName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT name FROM category";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li><a class="dropdown-item" href="#">'.$row["name"].'</a></li>';
        }
        mysqli_close($conn);
    }
}

?>

