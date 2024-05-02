<?php
require_once("../scripts/Utility.php");
$conn = Utility::connectionDatabase();
$sql = "SELECT product.*, sale.discount_percent as discount FROM `product` INNER JOIN sale ON product.ID_sale=sale.ID ORDER BY id DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

$activeElement = 1;
?>

<header>

    <?php
    if($_SESSION["logged_in"] == true) { ?>
        <h4>Ahoj, <?=$_SESSION["username"]?></h4>
    <?php }
    ?>

    <div id="carouselExampleIndicators" class="carousel slide h-50" data-bs-ride="carousel" style="margin-top: 50px">

        <div class="carousel-inner">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $price = $row["price"];
                if ($row["ID_sale"] != 1) {
                    $price = Utility::calculatePrice($price, $row["discount"]);
                }
                $price = number_format($price, 0, ',', ' ');
                if ($activeElement == 1) {
                    ?>
                    <div class="carousel-item active" data-bs-interval="5000">
                        <a href="../pages/product_detail.php?id=<?= $row["ID"] ?>">
                            <img src="../<?= $row["picture"] ?>" class="" height="250px" alt="...">
                            <h5><?= $row["title"] ?></h5>
                        </a>

                        <p><?= $price ?> Kč</p>

                    </div>
                    <?php
                    $activeElement++;
                } else {
                    ?>
                    <div class="carousel-item" data-bs-interval="5000">
                        <a href="../pages/product_detail.php?id=<?= $row["ID"] ?>">
                            <img src="../<?= $row["picture"] ?>" class=" " height="250px" alt="...">
                            <h5><?= $row["title"] ?></h5>
                        </a>
                        <p><?= $price ?> Kč</p>

                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</header>
<?php
mysqli_close($conn);

?>

