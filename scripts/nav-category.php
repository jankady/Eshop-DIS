<?php

class Nav_category
{
    public function nav()
    {

        require_once ("DBconnect.php");
        $conn = DBconnect::connectDatabase();
        $sql = "SELECT category.*,product.ID_category FROM product INNER JOIN category ON product.ID_category=category.ID";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li><a class="dropdown-item" href="../pages/product.php?">' . $row["name"] . '</a></li>';
        }
        mysqli_close($conn);
    }
}

?>

