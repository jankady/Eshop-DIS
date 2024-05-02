<?php
require_once("../scripts/Sessions.php");

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
    <link rel="stylesheet" href="../style/styleTesting.css">
    <link rel="stylesheet" href="../style/IndividualProduct.css">

    <title>Products</title>
</head>
<body>
<?php
//providing requierd files
require_once("../components/Nav.php");
require_once('../scripts/Filter.php');
require_once("../scripts/Utility.php");
require_once("../scripts/Product_card.php");

// DB connect and creating instances
$conn = Utility::connectionDatabase();
$card = new Product_card();
$filter = new Filters();

// Get current page number from URL (or set default to 1)
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;


?>

<div class="container-fluid">
    <section class="products row text-center">

        <div class="filter col-md-1 components">
            <form action="" method="get" onsubmit="return validateForm()">
                <input type="hidden" name="page" value="1">
                <input type="hidden" name="sort_by" value="1">

                <div class="price-range">
                    <h4>Cena</h4>
                    <label for="min-price">Minimalní cena</label>
                    <input type="number" id="min-price" name="min-price"
                           value="<?php echo isset($_GET['min-price']) ? htmlspecialchars($_GET['min-price']) : ''; ?>"/>
                    <br>
                    <label for="max-price">Maximalní cena</label>
                    <input type="number" id="max-price" name="max-price"
                           value="<?php echo isset($_GET['max-price']) ? htmlspecialchars($_GET['max-price']) : ''; ?>"/>
                </div>

                <div class="availability">
                    <hr>
                    <h4>Dostupnost</h4>
                    <input type="checkbox" id="availability"
                           name="availability" <?php echo isset($_GET['availability']) ? 'checked' : ''; ?>>
                    <label for="availability">Skladem</label>
                </div>

                <div class="sale">
                    <hr>
                    <h4>Sleva</h4>
                    <input type="checkbox" id="sale" name="sale" <?php echo isset($_GET['sale']) ? 'checked' : ''; ?>>
                    <label for="sale">Slevněné</label>
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
                        ?>
                        <div class="manufacturer-item" style="display: block; margin-bottom: 3px">
                            <input type="checkbox" id="<?php echo $row["name"]; ?>" name="manufacturers[]" value="<?php echo $row["ID"]; ?>" <?php echo $checked; ?>>
                            <label for="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></label>
                        </div>
                    <?php } ?>
                </div>

                <div class="Category">
                    <hr>
                    <h4>Kategorie</h4>
                    <?php
                    $sql = "SELECT * FROM category";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {

                        $checked = (isset($_GET['categories']) && in_array($row['ID'], $_GET['categories'])) ? 'checked' : '';
                    ?>
                            <div class="manufacturer-item" style="display: block; margin-bottom: 3px">
                                <input type="checkbox" id="<?=$row["name"];?>" name="categories[]" value="<?php echo $row["ID"]; ?>" <?php echo $checked; ?>>
                                <label for="<?= $row['name']; ?>"><?= $row['name']; ?></label><br>
                            </div>


                    <?php } ?>

                </div>

                <hr>
                <button type="submit" name="submit">Filtrovat</button>

                <?php
                // Check if any filters are applied and remove them if you want
                $filters_applied = isset($_GET['min-price']) && $_GET['min-price'] !== '' || isset($_GET['max-price']) && $_GET['max-price'] !== '' || isset($_GET['availability']) || isset($_GET['sale']) || (isset($_GET['manufacturers']) && !empty($_GET['manufacturers'])) || (isset($_GET['categories']) && !empty($_GET['categories']));

                //appiers only if filters are avialable, clearing is handled in Filter.php
                if ($filters_applied) {
                    echo '<button type="submit" name="clear_filters">Odstranit filtry</button>';
                }

                ?>
            </form>

        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Zachytíme kliknutí uživatele na jednotlivé možnosti
                $('.show-products .col-md-2').click(function () {
                    var sort_by = $(this).index() + 1; // Získáme pořadové číslo kliknutého sloupce (1, 2, 3)
                    var url = new URL(window.location.href); // Získáme URL adresu
                    url.searchParams.set('sort_by', sort_by); // Aktualizujeme hodnotu parametru sort_by
                    window.location.href = url.href; // Přesměrujeme na stránku s aktualizovanými parametry
                });
            });
        </script>

        <div class="container text-center col-lg-9">
            <div class="row show-products w-50 text-center">
                <div class="col-md-2"><a href="#" class="btn btn-link">Nejnovější</a></div>
                <div class="col-md-2"><a href="#" class="btn btn-link">Nejlevnější</a></div>
                <div class="col-md-2"><a href="#" class="btn btn-link">Nejdrahší</a></div>
                <div class="col-md-2"><a href="#" class="btn btn-link">Nejstarší</a></div>
            </div>
            <?php
            $card->product($filter->process());

            // strankování pro produkty

            if ($filters_applied) { //upravit podmínku
                $sql = $filter->process();

            } else {
                $sql = "SELECT product.*, sale.discount_percent AS discount  FROM product
                                  INNER JOIN sale ON product.ID_sale=sale.ID";
            }
            // Define number of products per page
            $productsPerPage = 6; // změnit 6 na 30 jinak se zobrazuje 6 produktu
            // Filter products based on filters (if any)
            $result = mysqli_query($conn, $sql);

            $filteredProducts = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $filteredProducts[] = $row;
            }

            //            print_r(count($filteredProducts));
            // Calculate total number of pages
            $totalPages = ceil(count($filteredProducts) / $productsPerPage);

            // Calculate offset for the current page
            //            $offset = ($currentPage - 1) * $productsPerPage;

            // Get products for the current page using array_slice on fetched products
            //            $products = array_slice($filteredProducts, $offset, $productsPerPage);


            // get url after ?
            $url = $_SERVER['REQUEST_URI'];
            // Oddělí parametry URL od adresy
            $parts = parse_url($url);
            // Získá parametry URL
            $query = $parts['query'];
            //            print_r($query);


            if ($totalPages > 1) {
                echo '<ul class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($currentPage == $i) ? 'active' : '';
                    $url = str_replace('page=' . $currentPage, 'page=' . $i, $query);
                    echo "<li class='page-item $activeClass'><a class='page-link' href='product.php?$url'>$i</a></li>";
                }
                echo '</ul>';
            }


            ?>
        </div>

    </section>
</div>

<?php
require_once("../components/Footer.php");

//end connection to DB
mysqli_close($conn);
?>

<!--script for handling invalid numbers in form-->
<script>
    function validateForm() {
        var minPrice = document.getElementById("min-price").value.trim();
        var maxPrice = document.getElementById("max-price").value.trim();

        // Check if minPrice and maxPrice are non-empty
        if (minPrice !== "" || maxPrice !== "") {
            // Check if minPrice and maxPrice are valid numeric values
            if ((!isNaN(minPrice) && parseFloat(minPrice) >= 0) || (!isNaN(maxPrice) && parseFloat(maxPrice) > 1)) {
                minPrice = parseFloat(minPrice);
                maxPrice = parseFloat(maxPrice);

                // Check if minPrice is negative or maxPrice is less than or equal to 1
                if (minPrice < 0) {
                    alert("Minimal price cannot be negative!");
                    return false; // Prevent form submission
                }
                if (maxPrice <= 1) {
                    alert("Maximal price should be greater than 1!");
                    return false; // Prevent form submission
                }

                // Check if minPrice is greater than maxPrice
                if (minPrice > maxPrice) {
                    alert("Minimal price cannot be greater than maximal price!");
                    return false; // Prevent form submission
                }
            } else {
                // Handle invalid input values
                alert("Please enter valid numeric values for prices!");
                return false; // Prevent form submission
            }
        }

        return true; // Allow form submission
    }
</script>

<!--style scripts for Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

</body>
</html>

