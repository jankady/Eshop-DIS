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
    <title>Eshop</title>

</head>
<body>
<?php
require_once("../components/Nav.php");
require_once("../scripts/Utility.php");
$conn = Utility::connectionDatabase();

?>

<div class="text-center">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Košík</h2>
            <?php
            if ($_SESSION["logged_in"] == true) {
                $user_id = $_SESSION["user_id"];



                // Připravit SQL dotaz pro získání záznamů z tabulky shopping_cart_item a potřebných atributů z tabulky product
                $sql_items = "SELECT sci.ID, sci.quantity, sci.ID_product, p.title, p.picture, p.price, p.number_of_products, p.availability, p.ID AS PI
    FROM shopping_cart_item AS sci 
    INNER JOIN shopping_cart AS sc ON sci.ID_cart = sc.ID 
    INNER JOIN product AS p ON sci.ID_product = p.ID 
    WHERE sc.ID_customer = ? 
    AND p.availability >= CURDATE() 
    AND sc.ID = (
        SELECT MAX(ID)
        FROM shopping_cart
        WHERE ID_customer = ?
    )";

                $stmt_items = mysqli_prepare($conn, $sql_items);
                mysqli_stmt_bind_param($stmt_items, "ii", $user_id, $user_id);
                mysqli_stmt_execute($stmt_items);
                $result_items = mysqli_stmt_get_result($stmt_items);

                // Inicializace celkové ceny košíku
                $total_price = 0;
            if (mysqli_num_rows($result_items) > 0) {
                // Vypsat hodnoty získané z tabulky shopping_cart_item
                echo "<table class='table'>";
                echo "<thead><tr><th> </th><th>Produkt</th><th>Skladem</th><th>Kvantita</th><th>Cena</th><th>Celková cena</th><th> </th></tr></thead>";
                echo "<tbody>";
            while ($row_item = mysqli_fetch_assoc($result_items)) {
                echo "<tr>";
                echo "<td><a href='../pages/product_detail.php?id=" . $row_item["ID_product"] . "'><img src='../" . $row_item['picture'] . "' alt='Product Picture' style='width:100px;height:100px;'></a>
</td>";
                echo "<td>" . $row_item['title'] . "</td>";

                // Logika pro vypsání dostupnosti produktu
                $availability = $row_item['number_of_products'];
                if ($availability >= 9) {
                    echo "<td style='color:green;'>Skladem: 9+</td>";
                } elseif ($availability > 5) {
                    echo "<td style='color:green;'>Skladem: 5+</td>";
                } else {
                    echo "<td style='color:green;'>Skladem: " . $availability . "</td>";
                }

                echo "<td>
        <form action='../scripts/Logged_cart.php' method='post' id='quantityForm_" . $row_item['ID'] . "'>
            <input type='hidden' name='product_id' value='" . $row_item['PI'] . "'>
            <input type='number' name='quantity' value='" . $row_item['quantity'] . "' min='0' class='w-50' onchange='updateQuantityAutomatically(this);'>
        </form>
    </td>";
                ?>
                <script>
                    // Funkce pro zachycení události změny hodnoty vstupního pole
                    function updateQuantityAutomatically(inputElement) {
                        var quantity = inputElement.value;

                        // Ověření, zda je množství nezáporné
                        if (quantity < 0) {
                            alert('Množství nemůže být záporné.');
                            inputElement.value = 1; // Nastavíme hodnotu na 0
                        } else {
                            inputElement.form.submit();
                        }
                    }
                </script>
            <?php
            echo "<td><strong>" . number_format($row_item['price'], 0, ',', ' ') . " Kč</strong></td>";

            // Výpočet ceny za všechny kusy
            $item_total_price = $row_item['price'] * $row_item['quantity'];
            echo "<td id='item_total_price_" . $row_item['ID'] . "'><strong>" . number_format($item_total_price, 0, ',', ' ') . " Kč</strong></td>";

            echo "<td>
        <form action='../scripts/Logged_cart.php' method='post'>
            <input type='hidden' name='product_id' value='" . $row_item['ID_product'] . "'>
            <button type='submit' name='removeFromCart' class='btn btn-danger btn-sm'>Odstranit</button>
        </form>
    </td>";
            echo "</tr>";
            // Přidat cenu aktuální položky k celkové ceně košíku
            $total_price += $item_total_price;
            }
            echo "</tbody></table>";

            // Vypsat celkovou cenu košíku
            echo "<p id='total_price'><strong>Celková cena: " . number_format($total_price, 0, ',', ' ') . " Kč</strong></p>";

            // Tlačítko pro provedení platby
            echo "<form action='../scripts/Logged_cart.php' method='post'>";
            echo "<input type='hidden' name='total_cost' value='$total_price '>";
            echo "<button type='submit' name='checkout' class='btn btn-primary'>Zaplatit</button>";
            echo "</form>";
            }
            else {
                // Pokud košík neobsahuje žádné produkty, zobrazí se zpráva
                echo "<div class='row'>";
                echo "<p>Košík je prázdný</p>";
                echo "<a href='Product.php?page=1&sort_by=1'>Zpět na produkty</a>";
                echo "</div>";
            }


            mysqli_stmt_close($stmt_items);
            }


            elseif (isset($_SESSION["cart"])) {
            // Extrahujte ID produktů z pole košíku
            $product_ids = array_column($_SESSION["cart"], "product_id");

            $product_id_arr = implode(', ', $product_ids);

            $sql = "SELECT product.*, sale.discount_percent AS discount FROM product 
            INNER JOIN sale ON product.ID_sale=sale.ID
            WHERE product.id IN ($product_id_arr) 
            ORDER BY FIELD(product.id, $product_id_arr) ASC";

            $result = mysqli_query($conn, $sql);

            $product_quantities = array();
            foreach ($_SESSION["cart"] as $item) {
                $product_quantities[$item['product_id']] = $item['quantity'];
            }
            $totalCost = 0;
            ?>

                <div class="row mb-4">
                    <div class="col">Obrázek</div>
                    <div class="col">Název</div>
                    <div class="col">Množství</div>
                    <div class="col">Cena za kus</div>
                    <div class="col">Celková cena</div>
                    <div class="col">Odebrat</div>
                </div>

                <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $quantity = $product_quantities[$row['ID']];
                $pricePerItem = ($row["ID_sale"] != 1) ? Utility::calculatePrice($row["price"], $row["discount"]) : $row["price"];
                $totalPrice = $pricePerItem * $quantity;
                $totalCost += $totalPrice;
                ?>

                <div class="row mb-4">
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
                        <form action="../scripts/Unlogged_cart.php" method='post'>
                            <input type='hidden' name='product_id' value='<?= $row["ID"] ?>'>
                            <input type='number' name='quantity' value='<?= $quantity ?>' min="0"
                                   onchange='updateQuantityAutomatically(this)' class="w-50">
                            <button type='submit' name='updateQuantity' style='display: none;'>Uložit</button>
                        </form>
                        <?php if (isset($product_quantities[$row['ID']])) {
                            echo "<p>Počet ks: {$product_quantities[$row['ID']]}</p>";
                        } ?>
                    </div>
                    <div class="col-2">
                        <p><?= number_format($pricePerItem, 0, ',', ' ') ?> Kč/ks</p>
                    </div>
                    <div class="col-2">
                        <p><strong><?= number_format($totalPrice, 0, ',', ' ') ?> Kč</strong></p>
                    </div>
                    <div class="col-2">
                        <form action="../scripts/Unlogged_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $row['ID'] ?>">
                            <button type="submit" class="btn btn-danger" name="removeFromCart"></button>
                        </form>
                    </div>
                </div>

            <?php } ?>
            <br>
            <?php
            $totalCost = number_format($totalCost, 0, ',', ' ');
            echo "<p><stroke>Celkem " . $totalCost . " Kč</stroke></p>";

            // Tlačítko pro provedení platby
            echo "<form action='../scripts/Unlogged_cart.php' method='post'>";
            echo "<input type='hidden' name='total_cost' value='$totalCost'>";
            echo "<button type='submit' name='checkout' class='btn btn-primary'>Zaplatit</button>";
            echo "</form>";
            }
            else {
            ?>
                <div class="row">
                    <p>Košík je prázdný</p>
                    <a href="product.php?page=1&sort_by=1">Zpět na produkty</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>


<?php
require_once("../components/Footer.php");
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