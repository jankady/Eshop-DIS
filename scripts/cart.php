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

    session_start();

    $product_id = $_POST["product_id"];

    echo "hi";
    // Zapsat do logu ID produktu
    error_log("Odstranění produktu ID: " . $product_id);

    // Získat pole ID produktů
    $product_ids = array_column($_SESSION["cart"], "product_id");

    // Zapsat do logu pole ID produktů
    error_log("Pole ID produktů: " . print_r($product_ids, true));

    // Najít index produktu v košíku
    $index = array_search($product_id, $product_ids);

    if ($index !== false) {
        // Zapsat do logu index produktu
        error_log("Produkt nalezen na indexu: " . $index);

        // Odstranit produkt z pole košíku
        unset($_SESSION["cart"][$index]);
    } else {
        // Zapsat do logu chybu
        error_log("Produkt nenalezen v košíku!");

        // Zobrazit chybovou zprávu uživateli
        echo "Produkt nenalezen v košíku!";
    }

    if (empty($_SESSION["cart"])) {
        // Odstranit session "cart"
        unset($_SESSION["cart"]);
    }


    // Přesměrovat zpět na stránku košíku
    header("Location: ../pages/shoppingCart.php?yes");
}


