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
require_once("../scripts/DBconnect.php");
$conn = DBconnect::connectionDatabase();

?>

<div class="container text-center">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Košík</h2>
            <?php
            if (isset($_SESSION["cart"])) {
                // Extract the product IDs from the cart array
                $product_ids = array_column($_SESSION["cart"], "product_id");

                // Display the product IDs as a comma-separated string
                $product_id_arr = implode(', ', $product_ids);
                //                echo $product_id_arr;
                $sql = "SELECT product.*, sale.discount_percent AS discount  FROM product
                    INNER JOIN sale ON product.ID_sale=sale.ID  WHERE product.id IN ($product_id_arr)";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="row mb-4 " style="height: 100px; border: red solid 1px">
                        <div class="col-2">
                            <a href="../pages/product_detail.php?id=<?= $row['ID'] ?>"><img
                                        src="../<?= $row['picture'] ?>" class="img-thumbnail"
                                        alt="<?= $row['title'] ?>"></a>
                        </div>
                        <div class="col-2">
                            <a href="../pages/product_detail.php?id=<?= $row['ID'] ?>"><h5
                                        class="card-title"><?= $row['title'] ?></h5></a>
                        </div>
                        <div class="col-2">
                            <p>počet ks</p>
                        </div>
                        <div class="col-2">
                            <div class="col"><p><?php if ($row["number_of_products"] > 5) echo "skladem: 9+ kusů";
                                    elseif ($row["number_of_products"] > 4) echo "skladem: " . $row["number_of_products"] . " kusů";
                                    elseif ($row["number_of_products"] > 1) echo "skladem: " . $row["number_of_products"] . " kusy";
                                    elseif ($row["number_of_products"] == 1) echo "skladem: " . $row["number_of_products"] . " kus";
                                    else echo "není skladem";

                                    ?></p></div>
                        </div>
                        <div class="col-2">
                            <div class="priceNumber">
                                <?php
                                $originalPrice = number_format($row["price"], 0, ',', ' ');

                                if ($row["ID_sale"] != 1) {
                                    $finalNumber = $row["price"] * ($row["discount"] / 100);
                                    $finalNumber = round($row["price"] - $finalNumber);

                                    $finalNumber = number_format($finalNumber, 0, ',', ' ');
                                    ?>
                                    <p><?= $finalNumber ?> Kč/ks</p>
                                    <?php
                                } else echo $originalPrice . " Kč/ks";
                                ?>
                            </div>
                        </div>
                        <div class="col-2">
                            <?php
                            if ($row["ID_sale"] != 1) {
                                $finalNumber = $row["price"] * ($row["discount"] / 100);
                                $finalNumber = round($row["price"] - $finalNumber);
                                $num = $finalNumber * 2;
                                echo "<strong>" . $num . "</strong>";
                            } else {
                                $num = $row["price"] * 1;
                                echo "<strong>" . $num . "</strong>";
                            }

                            ?>
                        </div>
                    </div>

                    <?php
                }

            }
            ?>
        </div>
    </div>
</div>


<?php
require_once("../components/footer.php");
mysqli_close($conn
) ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>
</html>