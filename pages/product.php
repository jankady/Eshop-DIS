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
    <title>Products</title>
</head>
<body>
<!--<h1>test</h1>-->
<?php
require_once("../components/nav.php");
require_once('../scripts/Filter.php');
require_once ("../scripts/DBconnect.php");
$conn = DBconnect::connectionDatabase();

?>
<div class="container-fluid">
    <section class="products row text-center" style="border: #4916b4 solid 1px">

        <div class="filter col-md-1 components">
            <form action="" method="get">
                <div class="price-range">
                    <h4>Cena</h4>
                    <label for="min-price">minimalní cena</label>
                    <input type="number" id="min-price" name="min-price"
                           value="<?php echo isset($_GET['min-price']) ? htmlspecialchars($_GET['min-price']) : ''; ?>"/>
                    <!-- saves the value after refresh  -->
                    <br>
                    <label for="max-price">maximalní cena</label>
                    <input type="number" id="max-price" name="max-price"
                           value="<?php echo isset($_GET['max-price']) ? htmlspecialchars($_GET['max-price']) : ''; ?>"/>
                    <!-- saves the value after refresh  -->
                </div>
                <div class="availability">
                    <hr>
                    <h4>Dostupnost</h4>
                    <input type="checkbox" id="availability"
                           name="availability" <?php echo isset($_GET['availability']) ? 'checked' : ''; ?>>
                    <!-- saves the value after refresh  -->
                    <label for="availability">skladem</label>
                </div>
                <div class="sale">
                    <hr>
                    <h4>Sleva</h4>
                    <input type="checkbox" id="sale" name="sale" <?php echo isset($_GET['sale']) ? 'checked' : ''; ?>>
                    <!-- saves the value after refresh  -->
                    <label for="sale">zlevněné</label>
                </div>
                <div class="manafacturer">
                    <hr>
                    <h4>Výrobce</h4>
                    <?php
                    $sql = "SELECT * FROM manafacturer";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {

                        // checkbox stay clicked after refresh
                        $checked = (isset($_GET['manufacturers']) && in_array($row['ID'], $_GET['manufacturers'])) ? 'checked' : '';
                        echo '<input type="checkbox" id="' . $row["name"] . '" name="manufacturers[]" value="' . $row["ID"] . '" ' . $checked . '>';
                        echo '<label for="' . $row['name'] . '">' . $row['name'] . '</label><br>';

                    }
                    ?>
                </div>
                <div class="Category">
                    <hr>
                    <h4>Kategorie</h4>
                    <?php
                    $sql = "SELECT * FROM category";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {

                        // checkbox stay clicked after refresh
                        $checked = (isset($_GET['categories']) && in_array($row['ID'], $_GET['categories'])) ? 'checked' : '';
                        echo '<input type="checkbox" id="' . $row["name"] . '" name="categories[]" value="' . $row["ID"] . '" ' . $checked . '>';
                        echo '<label for="' . $row['name'] . '">' . $row['name'] . '</label><br>';

                    }

                    mysqli_close($conn);
                    ?>
                </div>

                <hr>
                <button type="submit" name="submit">Filtrovat</button>

                <?php
                // Check if any filters are applied and remove them if you want
                $filters_applied = isset($_GET['min-price']) && $_GET['min-price'] !== '' || isset($_GET['max-price']) && $_GET['max-price'] !== '' || isset($_GET['availability']) || isset($_GET['sale']) || (isset($_GET['manufacturers']) && !empty($_GET['manufacturers'])) || (isset($_GET['categories']) && !empty($_GET['categories']));

                if ($filters_applied) {
                    echo '<button type="submit" name="clear_filters">Odstranit filtry</button>';
                }

                ?>
            </form>

        </div>
        <div class="container text-center col-lg-9">
            <div class="row show-products w-50 text-center">
                <div class="col-md-4">Nejnovější</div>
                <div class="col-md-4">Nejlevnější</div>
                <div class="col-md-4">Nejdrahší</div>
            </div>
            <?php
            require_once("../scripts/product-card.php");
            $card = new Product_card();
            $card->product();

            ?>
        </div>

    </section>
</div>
<?php
require_once("../components/footer.php");

?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>
</html>

