<?php

class Nav_category
{
    public function nav()
    {

        require_once ("DBconnect.php");
        $conn = DBconnect::connectDatabase();
        $sql = "SELECT name FROM category";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li><a class="dropdown-item" href="../pages/product.php?typ='.$row["name"].'">' . $row["name"] . '</a></li>';
        }
        mysqli_close($conn);
    }
}

?>

