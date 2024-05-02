<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../pages/Index.php"><img src="../img/mobile-shopping.png" alt="eshop" width="30"
                                                               height="24"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../pages/Index.php">Domů</a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link " href="../pages/product.php?page=1&sort_by=1">Produkty</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../pages/Contact.php">Kontakt</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <?php
                require_once("../scripts/Utility.php");


                if ($_SESSION["logged_in"]) {

                    $conn = Utility::connectionDatabase();
                    // Předpokládejme, že máte databázové připojení a uživatel je přihlášen
                    // Zde provedeme SQL dotaz, abychom zjistili, zda má uživatel něco v košíku
                    $user_id = $_SESSION["user_id"]; // Předpokládáme, že máte uloženo ID přihlášeného uživatele


                    $sql = "SELECT COUNT(shopping_cart_item.ID_product) AS pocet_produktu
                                FROM shopping_cart_item
                                JOIN shopping_cart ON shopping_cart_item.ID_cart = shopping_cart.ID
                                WHERE shopping_cart.ID = (SELECT MAX(ID) FROM shopping_cart WHERE ID_customer = ?)";

                    $stmt = $conn->prepare($sql);

                    $stmt->bind_param("s", $user_id);
                    $stmt->execute();
                    $stmt->bind_result($cart_count);
                    $stmt->fetch(); ?>

                    <li><p style="margin-top: 8px; margin-right: 20px"><?= $_SESSION["username"] ?></p></li>
                    <?php
                    if ($cart_count > 0) {
                        ?>
                        <li><a href="../pages/Shopping_cart.php"><img src="../img/shopCartFull.png" alt=""></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="../pages/Shopping_cart.php"><img src="../img/shopCartEmpty.png" alt=""></a></li>
                        <?php
                    }
                    ?>
                    <li>
                        <form method="post" action="../scripts/Account.php" style="margin-left: 50px">
                            <button type="submit" name="sign_out" class="btn btn-primary">Odhlásit se</button>
                        </form>
                    </li>
                <?php } elseif ($_SESSION["logged_in"] == false) {
                    if (isset($_SESSION["cart"])) {
                        ?>
                        <li><a href="../pages/Shopping_cart.php"><img src="../img/shopCartFull.png" alt=""></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="../pages/Shopping_cart.php"><img src="../img/shopCartEmpty.png" alt=""></a></li>
                        <?php
                    }
                    ?>
                    <li style="margin-top: 8px"><a href="../pages/Login.php"
                                                   style="text-decoration: none; color: #1a1d20"><span
                                    class="glyphicon glyphicon-log-in" style="margin-left: 50px"></span> Přihlásit se</a></li>
                    <li style=" margin-right: 50px; margin-top: 8px"><a href="../pages/Registration.php"
                                                                        style="text-decoration: none; color: #1a1d20"><span
                                    class="glyphicon glyphicon-log-in" style="margin-left: 20px"></span>
                            Registrace</a></li>
                    <?php
                }
                ?>

            </ul>
        </div>
    </div>
</nav>

<?php

?>

