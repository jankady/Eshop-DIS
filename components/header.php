<?php
require_once("../scripts/Utility.php");
$conn = Utility::connectionDatabase();
$sql = "SELECT product.*, sale.discount_percent as discount FROM `product` INNER JOIN sale ON product.ID_sale=sale.ID ORDER BY id DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

$activeElement = 1;
?>

<header>
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                if ($activeElement == 1) {
                    ?>
                    <div class="carousel-item active">
                        <img src="../<?= $row["picture"] ?>" class="d-block w-50" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= $row["title"] ?></h5>
                            <p><?= $row["price"] ?></p>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="carousel-item">
                        <img src="../<?= $row["picture"] ?>" class="d-block w-50" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= $row["title"] ?></h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
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

