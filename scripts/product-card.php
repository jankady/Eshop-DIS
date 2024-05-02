<?php

class Product_card
{
    //creates individual items
    public function product($sql): void
    {
        require_once("Utility.php");

        $conn = Utility::connectionDatabase();
        $maxProducts = 6;

        $sorted_by = $_GET['sort_by'];
        $currentPage = ($_GET['page'] - 1) * $maxProducts; // změnit 6 na 30 jinak se zobrazuje 6 produktu

        if ($sorted_by == 1) {
            $sort = "ORDER BY product.ID DESC";
        } elseif ($sorted_by == 2) {
            $sort = "ORDER BY product.price ASC";
        } elseif ($sorted_by == 3) {
            $sort = "ORDER BY product.price DESC";
        } elseif ($sorted_by == 4) {
            $sort = "ORDER BY product.ID ASC";
        } else {
            $sort = ""; // Pokud není definováno řazení, nevytváří se ORDER BY klauzule
        }

        // is called when you click on Products in nav
        if ($sql == NULL) {
            $sql = "SELECT product.*, sale.discount_percent AS discount FROM product
                                  INNER JOIN sale ON product.ID_sale=sale.ID " . $sort . "  LIMIT " . $maxProducts . " OFFSET ? "; // taky změnit

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $currentPage);
            $stmt->execute();

            $result = $stmt->get_result();
        } else {
            $sql .= " " . $sort . " LIMIT " . $maxProducts . " OFFSET " . $currentPage;   // změnit 6 na 30 jinak se zobrazuje 6 produktu
            $result = mysqli_query($conn, $sql);
        }

        ?>
        <div class="row">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-4 mt-2 mb-2">
                    <div class="card" style="max-width: 25rem; height: 31rem">
                        <a href="../pages/product_detail.php?id=<?= $row['ID'] ?>"><h5
                                    class="card-title"><?= $row['title'] ?></h5></a>
                        <div class="card-body">
                            <a href="../pages/product_detail.php?id=<?= $row['ID'] ?>"><img
                                        src="../<?= $row['picture'] ?>" class="card-img-top" alt="<?= $row['title'] ?>"></a>
                            <div class="productInfo">
                                <p class="card-text"><?= $row['description'] ?></p>
                            </div>
                            <div class="card-text row">
                                <div class="priceNumber col align-content-center">
                                    <?php
                                    $salePrice = Utility::calculatePrice($row["price"], $row["discount"]);
                                    $originalPrice = number_format($row["price"], 0, ',', ' ');
                                    $salePricerFloat = number_format($salePrice, 0, ',', ' ');

                                    if ($row["ID_sale"] != 1) {
                                        ?>
                                        <!--  show sale if it there is any-->
                                        <p><?= "SALE " . $row["discount"] . "%" ?></p>
                                        <div class="priceNumber">
                                            <p><?= $salePricerFloat ?> Kč</p>
                                            <p class="fs-6 text-decoration-line-through"><?= $originalPrice ?> Kč</p>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <p class="align-self-center"><?= $salePricerFloat ?> Kč</p>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="row col">
                                    <div class="">
                                        <p><?php if ($row["number_of_products"] > 5) echo "skladem: 9+ kusů";
                                            elseif ($row["number_of_products"] > 4) echo "skladem: " . $row["number_of_products"] . " kusů";
                                            elseif ($row["number_of_products"] > 1) echo "skladem: " . $row["number_of_products"] . " kusy";
                                            elseif ($row["number_of_products"] == 1) echo "skladem: " . $row["number_of_products"] . " kus";
                                            else echo "<p class='text-warning'>není skladem</p>";

                                            ?></p>
                                    </div>
                                    <div class="">
                                        <?php
                                        if ($row["number_of_products"] != 0 && $_SESSION["logged_in"] == false) {
                                            ?>

                                            <form action="../scripts/unlogined_cart.php" method="post">
                                                <button type="submit" name="addToCart" class="btn btn-primary">add to
                                                    cart
                                                </button>
                                                <input type="hidden" name="product_id" value='<?= $row["ID"] ?>'>



                                            </form>



                                            <?php
                                        } elseif ($row["number_of_products"] != 0 && $_SESSION["logged_in"] == true){
                                            ?>
                                            <form action="../scripts/logined_cart.php" method="post">
                                                <button type="submit" name="addToCart" class="btn btn-primary">add to
                                                    cart
                                                </button>
                                                <input type="hidden" name="product_id" value='<?= $row["ID"] ?>'>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
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
