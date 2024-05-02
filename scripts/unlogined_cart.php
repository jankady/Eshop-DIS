<?php

if (isset($_POST['addToCart'])) {

    session_start();

    $product_id = $_POST["product_id"];

    // Zkontrolovat, zda již košík existuje
    if (isset($_SESSION["cart"])) {
        // Vyhledat položku se stejným product_id
        $found = false;
        foreach ($_SESSION["cart"] as &$item) {
            if ($item["product_id"] == $product_id) {
                // Aktualizovat množství produktu
                $item["quantity"] = isset($item["quantity"]) ? $item["quantity"] + 1 : 2; // Začít na 1 nebo 2
                $found = true;
                break;
            }
        }

        // Pokud produkt nebyl nalezen, přidat ho jako novou položku
        if (!$found) {
            $_SESSION["cart"][] = array(
                'product_id' => $product_id,
                'quantity' => 1
            );
        }
    } else {
        // Vytvořit košík, pokud ještě neexistuje
        $_SESSION["cart"] = array(
            array(
                'product_id' => $product_id,
                'quantity' => 1
            )
        );
    }

    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../index.php"); // If no referring page, redirect to index.php
    }
    exit();
}
if (isset($_POST['removeFromCart'])) {
    // Spustit session
    session_start();

    // Získat ID produktu
    $product_id = $_POST['product_id'];

    // Najít index produktu v košíku
    foreach ($_SESSION["cart"] as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $index = $key;
            break;
        }
    }

    // Odstranit produkt z pole košíku
    if (isset($index)) {
        unset($_SESSION["cart"][$index]);
    }

    // Odstranit session "cart" pokud je prázdná
    if (empty($_SESSION["cart"])) {
        unset($_SESSION["cart"]);
    }

    // Přesměrovat zpět na stránku košíku s ID produktu
    header("Location: ../pages/shoppingCart.php");
    exit();

}

if (isset($_POST['checkout'])) {
    // Přesměrování na stránku s formulářem pro zadání e-mailu
    unset($_SESSION["cart"]);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Potvrzení nákupu</title>
    </head>
    <body>
    <h1>Děkujeme za nákup!</h1>
    <p>Vaše objednávka byla úspěšně provedena.</p>
    <p>Děkujeme za nákup!</p>
    <a class="nav-link" href="../pages/index.php">Zpět na úvodní stránku</a>
    </body>
    </html>


<?php
    exit();
}



    session_start();

    // Získání ID produktu a nového množství z formuláře
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];

    require_once ("Utility.php");
    $conn = Utility::connectionDatabase();

    // Získání dostupného množství produktu z databáze
    $sql = "SELECT number_of_products FROM product WHERE ID = $product_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $available_quantity = $row['number_of_products'];

    // Pokud je nové množství 0, odebereme položku z košíku
    if ($new_quantity == 0) {
        foreach ($_SESSION["cart"] as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION["cart"][$key]);
                break;
            }
        }

        if (empty($_SESSION["cart"])) {
            unset($_SESSION["cart"]);
        }

    } else {
        // Ověření, zda zadané množství nepřekračuje dostupné množství
        if ($new_quantity <= $available_quantity) {
            // Aktualizace množství produktu v session cart
            foreach ($_SESSION["cart"] as &$item) {
                if ($item['product_id'] == $product_id) {
                    $item['quantity'] = $new_quantity;
                    break;
                }
            }
        } else {
            // Pokud zadané množství překračuje dostupné množství, upravíme ho na maximálně dostupné množství
            $new_quantity = $available_quantity;
            // Aktualizace množství produktu v session cart
            foreach ($_SESSION["cart"] as &$item) {
                if ($item['product_id'] == $product_id) {
                    $item['quantity'] = $new_quantity;
                    break;
                }
            }
        }
    }

if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: ../index.php"); // If no referring page, redirect to index.php
}
exit();


