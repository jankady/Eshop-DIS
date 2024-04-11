<?php
require_once("../scripts/sessions.php");
SessionClass::checkSessions();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../img/shop.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Eshop</title>

</head>
<body>
<?php
require_once("../components/nav.php");
require_once("../scripts/Utility.php");
$conn = Utility::connectionDatabase();

?>

<div class="container text-center">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Košík</h2>
            <?php
            if (isset($_SESSION["cart"])) {
                // Extrahujte ID produktů z pole košíku
                $product_ids = array_column($_SESSION["cart"], "product_id");

                $product_id_arr = implode(', ', $product_ids);

                $sql = "SELECT product.*, sale.discount_percent AS discount FROM product 
                                                                INNER JOIN sale ON product.ID_sale=sale.ID
                                                                WHERE product.id IN ($product_id_arr) 
                                                                ORDER BY FIELD(product.id, $product_id_arr) ASC";
//                print_r($sql);
                $result = mysqli_query($conn, $sql);

                $product_quantities = array();
                foreach ($_SESSION["cart"] as $item) {
                    $product_quantities[$item['product_id']] = $item['quantity'];
                }
                $totalCost=0;
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="row mb-4 " style="height: 100px">
                        <div class="col-2">
                            <a href="../pages/product_detail.php?id=<?= $row['ID'] ?>"><img
                                        src="../<?= $row['picture'] ?>" class="img-thumbnail"
                                        alt="<?= $row['title'] ?>"></a>
                        </div>
                        <div class="col-2">
                            <a href="../pages/product_detail.php?id=<?= $row['ID'] ?>"><h5
                                        class="card-title"><?= $row['title'] ?></h5></a>
                        </div>

                        <script>
                            // Funkce pro zachycení události změny hodnoty vstupního pole
                            function updateQuantityAutomatically(inputElement) {
                                var quantity = inputElement.value;

                                // Ověření, zda je množství nezáporné
                                if (quantity < 0) {
                                    alert('Množství nemůže být záporné.');
                                    inputElement.value = 0; // Nastavíme hodnotu na 0
                                } else {
                                    inputElement.form.submit();
                                }
                            }
                        </script>
                        <div class="col-2">

                            <form action="../scripts/unlogined_cart.php" method='post'>
                                <input type='hidden' name='product_id' value='<?=$row["ID"]?>'>
                                <input type='number' name='quantity' value='<?=$product_quantities[$row['ID']]?>' min="0" onchange='updateQuantityAutomatically(this)' class="w-50">
                                <button type='submit' name='updateQuantity' style='display: none;'>Uložit</button>
                                </form>
                            <?php
                            // Pokud je produkt v košíku, vypište jeho množství
                            if (isset($product_quantities[$row['ID']])) {
                                echo "<p>počet ks: {$product_quantities[$row['ID']]}</p>";
                            }
                            ?>
                        </div>
                        <div class="col-2">
<!--                            <div class="col">-->
<!--                                <p>--><?php //if ($row["number_of_products"] > 5) echo "skladem: 9+ kusů";
//                                    elseif ($row["number_of_products"] > 4) echo "skladem: " . $row["number_of_products"] . " kusů";
//                                    elseif ($row["number_of_products"] > 1) echo "skladem: " . $row["number_of_products"] . " kusy";
//                                    elseif ($row["number_of_products"] == 1) echo "skladem: " . $row["number_of_products"] . " kus";
//                                    else echo "není skladem";
//
//                                    ?><!--</p>-->
<!--                            </div>-->
                        </div>
                        <?php
                        foreach ($_SESSION["cart"] as $item) {

                            if ($item['product_id'] == $row['ID']) {
                                // Získáme množství a cenu pro danou položku
                                $quantity = $item['quantity'];
                                break;
                            }
                        }

                        if ($row["ID_sale"] != 1) {
                            $sale = Utility::calculatePrice($row["price"], $row["discount"]);

                            $saledPrice = number_format($sale, 0, ',', ' ');
                            $finalSaledPrice = number_format($sale * $quantity, 0, ',', ' ');


                            ?>
                            <div class="col-2 pricePerStock">
                                <p><?= $saledPrice ?> Kč/ks</p>
                            </div>
                            <div class="col-2 finalPrice">
                                <p><strong><?= $finalSaledPrice ?></strong></p>
                            </div>

                            <?php
                            $totalCost+=$sale * $quantity;
                        } else {
                            $unsaledPrice = number_format($row["price"], 0, ',', ' ');
                            $finalUnsaledPrice = number_format($row["price"] * $quantity, 0, ',', ' ');

                            ?>
                            <div class="col-2 pricePerStock">
                                <p><?= $unsaledPrice ?> Kč/ks</p>
                            </div>
                            <div class="col-2 finalPrice">
                                <p><strong><?= $finalUnsaledPrice ?></strong></p>
                            </div>
                            <?php
                            $totalCost+=$row["price"] * $quantity;
                        }
                        ?>

                        <div class="col-1">
                            <form action="../scripts/unlogined_cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?= $row['ID'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" name="removeFromCart"></button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                echo "<br>";
                $totalCost = number_format($totalCost, 0, ',', ' ');

                echo "<p><stroke>Celkem " . $totalCost . " Kč</stroke></p>";

            } else {
                ?>
                <div class="row">
                    <p>Košík je prázdny</p>
                    <a href="product.php?page=1&sort_by=1">zpět na produkty</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>


<?php
require_once("../components/footer.php");
mysqli_close($conn)
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>
</html>