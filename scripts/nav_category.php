<?php

class nav_category
{
    //was used in NAV, now it is useless
    public function nav()
    {

        require_once("utility.php");
        $conn = utility::connectionDatabase();
        $sql = "SELECT name FROM category";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li><a class="dropdown-item" href="../pages/product.php?typ='.$row["name"].'">' . $row["name"] . '</a></li>';
        }
        mysqli_close($conn);
    }
}

?>

