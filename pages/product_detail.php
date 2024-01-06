<?php
require_once("../scripts/DBconnect.php");
$conn = DBconnect::connectDatabase();
$productId = $_GET['id'];
//$sql = "SELECT *, FROM `product` WHERE `ID` = ? ";
//$sql = "SELECT product.*, sale.discount_percent as discount FROM `product` INNER JOIN sale ON product.ID_sale=sale.ID WHERE product.ID = ?";
$sql = "SELECT product.*, sale.discount_percent as discount FROM `product` INNER JOIN sale ON product.ID_sale=sale.ID WHERE product.ID = ?";


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
    <link rel="stylesheet" href="../style/style.css">
    <title>Eshop-<?= $product["title"] ?></title>
</head>
<body>
<?php
require_once("../components/nav.php");
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
                        <p>Skladem: <?= $product["number_of_products"] ?>ks</p>
                        <p>
                            <?php
                            $storeTime = strtotime("+3 days");
                            $dayArrive = date("d.m", $storeTime);
                            echo " " . date("D", $dayArrive) . " " . $dayArrive . " at your place";
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
                                <div class="sale">
                                    <?php
                                    if ($product["ID_sale"] != 1) {
                                        echo "SALE " . $product["discount"] . "%";
                                    }
                                    ?>
                                </div>
                                <div class="priceNumber">
                                    <?php
                                    $originalPrice = number_format($product["price"], 0, ',', ' ');

                                    if ($product["ID_sale"] != 1) {
                                        $finalNumber = $product["price"] * ($product["discount"] / 100);
                                        $finalNumber =round($product["price"] - $finalNumber)." Kč";
                                        $finalNumberFloat= (float)$finalNumber;
                                        $finalNumberFloat = number_format($finalNumberFloat, 0, ',', ' ');
                                        ?>
                                        <p><?= $finalNumberFloat ?> Kč</p>
                                        <p class="fs-6 text-decoration-line-through"><?= $originalPrice?> Kč</p>
                                        <?php
                                    } else echo $originalPrice . " Kč";
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn btn-primary">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
<?php
$stmt->close();
?>
</body>
</html>
