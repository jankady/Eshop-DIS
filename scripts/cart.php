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

    header("Location: ../pages/product.php?page=1 ");
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
}




