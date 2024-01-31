<?php

class Product_card
{
    public function product(): void
    {
        require_once("DBconnect.php");
        $conn = DBconnect::connectionDatabase();
        $productType = null;
        if (isset($_GET['typ'])) {
            $productType = $_GET['typ'];
//            echo $productType;
            $sql = "SELECT product.*, sale.discount_percent AS discount, category.name  FROM `product`
                    INNER JOIN sale ON product.ID_sale=sale.ID
                    INNER JOIN category ON product.ID_category = category.ID
                    WHERE category.name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $productType);
            $stmt->execute();
            $result = $stmt->get_result();

        } else {

            $sql = "SELECT product.*, sale.discount_percent as discount FROM `product`
                    INNER JOIN sale ON product.ID_sale=sale.ID";
            $result = mysqli_query($conn, $sql);

        }

        ?>
        <div class="row">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
//                echo var_dump($row);
                ?>
                <div class="col-4 mt-2 mb-2">
                    <div class="card" style="max-width: 25rem; max-height: 40rem">
                        <a href="../pages/product_detail.php?id=<?= $row['ID'] ?>"><h5
                                    class="card-title"><?= $row['title'] ?></h5></a>
                        <div class="card-body">
                            <a href="../pages/product_detail.php?id=<?= $row['ID'] ?>"><img
                                        src="../<?= $row['picture'] ?>" class="card-img-top" alt="<?= $row['title'] ?>"></a>
                            <p class="card-text"><?= $row['description'] ?></p>
                            <div class="card-subtitle">
                                <!--            Výpočet slevy a zobrazení slevy                    -->
                                <div class="sale">
                                    <?php
                                    if ($row["ID_sale"] != 1) {
                                        echo "SALE " . $row["discount"] . "%";
                                    }
                                    ?>
                                </div>
                                <div class="priceNumber">
                                    <?php
                                    $originalPrice = number_format($row["price"], 0, ',', ' ');

                                    if ($row["ID_sale"] != 1) {
                                        $finalNumber = $row["price"] * ($row["discount"] / 100);
                                        $finalNumber = round($row["price"] - $finalNumber);

                                        $finalNumber = number_format($finalNumber, 0, ',', ' ');
                                        ?>
                                        <p><?= $finalNumber ?> Kč</p>
                                        <p class="fs-6 text-decoration-line-through"><?= $originalPrice ?> Kč</p>
                                        <?php
                                    } else echo $originalPrice . " Kč";
                                    ?>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary">Add to cart</a>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
        <?php
//        $stmt->close();
        mysqli_close($conn);
    }
}

?>
