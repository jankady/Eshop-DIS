<?php

class Product_card
{
    public function product(): void
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
        $sql = "SELECT `title`,`picture`,REPLACE(FORMAT(`price`, '000 000'), ',', ' ') as price,`number_of_products`,`ID_category`,`description` FROM product";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="row">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-4 mt-2 mb-2">
                    <div class="card" style="max-width: 25rem; max-height: 40rem">
                        <h5 class="card-title"><?= $row['title'] ?></h5>
                        <div class="card-body">
                            <img src="../<?= $row['picture'] ?>" class="card-img-top" alt="<?= $row['title'] ?>" >
                            <p class="card-text"><?= $row['description'] ?></p>
                            <p class="card-subtitle"><?= $row['price'] ?> Kč</p>
                            <a href="#" class="btn btn-primary">Add to cart</a>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
        <?php
        mysqli_close($conn);
    }
}

?>
