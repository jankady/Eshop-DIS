<?php
class Filter_Components {
    public function showComponents() {
        require_once ("DBconnect.php");
        $conn = DBconnect::connectionDatabase();
        $sql = "SELECT * FROM product";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li><a class="dropdown-item" href="../pages/product.php?typ='.$row["name"].'">' . $row["name"] . '</a></li>';
        }
        mysqli_close($conn);
    }
}