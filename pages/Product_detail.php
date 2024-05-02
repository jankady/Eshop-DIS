<?php
require_once("../scripts/Utility.php");
require_once("../scripts/Sessions.php");

$conn = Utility::connectionDatabase();
$productId = $_GET['id'];
SessionClass::checkSessions();

$sql = "SELECT product.*, sale.discount_percent as discount FROM `product` INNER JOIN sale ON product.ID_sale=sale.ID WHERE product.ID = ?";

//bind parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productId);
$stmt->execute();
$result = $stmt->get_result();

$product = $result->fetch_assoc();


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
    <!--    <link rel="stylesheet" href="../style/styleTesting.css">-->
    <link rel="stylesheet" href="../style/nav.css">

    <title>Eshop-<?= $product["title"] ?></title>
</head>
<body>
<?php
require_once("../components/Nav.php");
?>

<div class="container-fluid">
    <section class="products">
        <div class="container text-center">
            <div class="row title">
                <h3><?= $product["title"] ?></h3>
            </div>
            <div class="row">
                <div class="col-6"><img src="../<?= $product["picture"] ?>" class="img-fluid"
                                        alt="<?= $product["title"] ?>"></div>
                <div class="col-6 row">

                    <p> <?= $product["description"] ?></p>
                    <div class="col-lg-12 align-self-end" style="background: darkgrey; width: 100%">
                        <!--   number of avialable products/products on stock        -->
                        <p>Skladem: <?= $product["number_of_products"] ?> ks</p>
                        <p>
                            <?php
                            // calculate when your stuff should arrive, now it is 3days
                            $storeTime = strtotime("+3 days");
                            $dayArrive = date("d.m", $storeTime);
                            echo " " . date("D", $dayArrive) . " " . $dayArrive . " u Vás doma";
                            ?>
                        </p>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="payment">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="price">
                                <?php
                                $salePrice = Utility::calculatePrice($product["price"], $product["discount"]);
                                $originalPrice = number_format($product["price"], 0, ',', ' ');
                                $salePricerFloat = number_format($salePrice, 0, ',', ' ');

                                if ($product["ID_sale"] != 1) {

                                    ?>
                                    <!--  show sale if it there is any-->
                                    <p><?= "SALE " . $product["discount"] . "%" ?></p>
                                    <div class="priceNumber">
                                        <p><?= $salePricerFloat ?> Kč</p>
                                        <p class="fs-6 text-decoration-line-through"><?= $originalPrice ?> Kč</p>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <p><?= $salePricerFloat ?> Kč</p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <?php

                            if ($_SESSION["logged_in"] == true) {
                                ?>
                                <form action="../scripts/Logged_cart.php" method="post">
                                    <button type="submit" name="addToCart" class="btn btn-primary">Přidat do košíku
                                    </button>
                                    <input type="hidden" name="product_id" value='<?= $product["ID"] ?>'>
                                </form>
                                <?php
                            } else if ($product["number_of_products"] != 0) {
                                ?>
                                <form action="../scripts/Unlogged_cart.php" method="post">
                                    <button type="submit" name="addToCart" class="btn btn-primary">Přidat do košíku
                                    </button>
                                    <input type="hidden" name="product_id" value='<?= $product["ID"] ?>'>
                                </form>
                                <?php
                            } else {
                                echo "<p class='text-warning'>Není Skladem</p>";
                            }

                            ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<?php
require_once("../components/Footer.php");
?>

<!--style scripts for Bootstrap-->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
<?php
//close connection to DB
$stmt->close();
?>
</body>
</html>
