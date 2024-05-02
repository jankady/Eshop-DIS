<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../pages/index.php"><img src="../img/mobile-shopping.png" alt="eshop" width="30"
                                                               height="24"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../pages/index.php">Home</a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link " href="../pages/product.php?page=1&sort_by=1">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../pages/contact.php">Contact</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <?php
                require_once("../scripts/Utility.php");


                if ($_SESSION["logged_in"] == true) {

                    $conn = Utility::connectionDatabase();
                    // Předpokládejme, že máte databázové připojení a uživatel je přihlášen
                    // Zde provedeme SQL dotaz, abychom zjistili, zda má uživatel něco v košíku
                    $user_id = $_SESSION["user_id"]; // Předpokládáme, že máte uloženo ID přihlášeného uživatele

                    $sql = "SELECT COUNT(shopping_cart_item.ID_product) AS pocet_produktu
FROM shopping_cart_item
JOIN shopping_cart ON shopping_cart_item.ID_cart = shopping_cart.ID
WHERE shopping_cart.ID_customer = ?";

                    $stmt = $conn->prepare($sql);

                    $stmt->bind_param("s", $user_id);
                    $stmt->execute();
                    $stmt->bind_result($cart_count);
                    $stmt->fetch();

                    if ($cart_count > 0) {
                        ?>
                        <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartFull.png" alt=""></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartEmpty.png" alt=""></a></li>
                        <?php
                    }
                    ?>
                    <li>
                        <form method="post" action="../scripts/account.php">
                            <button type="submit" name="sign_out" class="btn btn-primary">Sign Out</button>
                        </form>
                    </li>
                <?php } elseif ($_SESSION["logged_in"] == false) {
                    if (isset($_SESSION["cart"])) {
                        ?>
                        <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartFull.png" alt=""></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartEmpty.png" alt=""></a></li>
                        <?php
                    }
                    ?>
                    <li><a href="../pages/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <li><a href="../pages/registration.php"><span class="glyphicon glyphicon-log-in"></span>
                            Register</a></li>
                    <?php
                }
                ?>

            </ul>
        </div>
    </div>
</nav>

<?php
/*
 <?php
// Předpokládejme, že máte databázové připojení a uživatel je přihlášen
// Zde provedeme SQL dotaz, abychom zjistili, zda má uživatel něco v košíku
$user_id = $_SESSION["user_id"]; // Předpokládáme, že máte uloženo ID přihlášeného uživatele

$sql = "SELECT COUNT(*) as count FROM cart WHERE user_id = $user_id";
// Spusťte dotaz na databázi, zkontrolujte, zda uživatel má něco v košíku
// $result = mysqli_query($connection, $sql); // Předpokládáme, že používáte MySQLi

// Zde předpokládáme, že máte uložené výsledky dotazu a proměnnou $cart_count, která obsahuje počet položek v košíku
$cart_count = 5; // Například počet položek v košíku

if ($_SESSION["logged_in"] == true) {
    if ($cart_count > 0) {
        ?>
        <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartFull.png" alt=""></a></li>
        <?php
    } else {
        ?>
        <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartEmpty.png" alt=""></a></li>
        <?php
    }
?>
    <li>
        <form method="post" action="../scripts/account.php">
            <button type="submit" name="sign_out" class="btn btn-primary">Sign Out</button>
        </form>
    </li>
<?php } else { ?>
    <li><a href="../pages/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    <li><a href="../pages/registration.php"><span class="glyphicon glyphicon-log-in"></span>
            Register</a></li>
<?php } ?>
 */

/*
 *
 * SELECT COUNT(sc_item.ID) AS cart_count
FROM shopping_cart sc
JOIN shopping_cart_item sc_item ON sc.ID = sc_item.ID_cart
WHERE sc.ID_customer = :customer_id;


 *
 * <?php
// Předpokládejme, že databázový dotaz vrátil 3 položky v košíku
$cart_count = 3;

if ($_SESSION["logged_in"] == true) {
  if ($cart_count > 0) {
    ?>
    <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartFull.png" alt=""></a></li>
    <?php
  } else {
    ?>
    <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartEmpty.png" alt=""></a></li>
    <?php
  }
?>
  <li>
    <form method="post" action="../scripts/account.php">
      <button type="submit" name="sign_out" class="btn btn-primary">Sign Out</button>
    </form>
  </li>
<?php } else { ?>
  <li><a href="../pages/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
  <li><a href="../pages/registration.php"><span class="glyphicon glyphicon-log-in"></span>
      Register</a></li>
<?php } ?>

SELECT COUNT(*) AS cart_count
FROM cart
WHERE user_id = :user_id;


<?php
// Předpokládejme, že máte databázové připojení a proměnnou $user_id s ID přihlášeného uživatele

// Připravte dotaz
$sql = "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);

// Vložte parametry
$stmt->bindParam(':user_id', $user_id);

// Spusťte dotaz
$stmt->execute();

// Získejte výsledek
$result = $stmt->fetch();

// Získejte počet položek v košíku
$cart_count = $result['cart_count'];

// Podmíněné zobrazení obrázku košíku
if ($_SESSION["logged_in"] == true) {
  if ($cart_count > 0) {
    ?>
    <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartFull.png" alt=""></a></li>
    <?php
  } else {
    ?>
    <li><a href="../pages/shoppingCart.php"><img src="../img/shopCartEmpty.png" alt=""></a></li>
    <?php
  }
?>
  <li>
    <form method="post" action="../scripts/account.php">
      <button type="submit" name="sign_out" class="btn btn-primary">Sign Out</button>
    </form>
  </li>
<?php } else { ?>
  <li><a href="../pages/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
  <li><a href="../pages/registration.php"><span class="glyphicon glyphicon-log-in"></span>
      Register</a></li>
<?php } ?>
 */
?>

