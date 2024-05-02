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
    header("Location: ../pages/checkout_email.php");
    exit();
}

// Na stránce s odesláním e-mailu (checkout_email.php)
if (isset($_POST['submit_email'])) {
    // Zde můžete provádět validaci e-mailu a další logiku

    // Získání zadané e-mailové adresy
    $email = $_POST['email'];

    // Obsah e-mailu
    $subject = "Potvrzení objednávky";

    // Zpráva e-mailu s obsahem košíku
    $message = "
    <html>
    <head>
    <title>Potvrzení objednávky</title>
    </head>
    <body>
    <h2>Děkujeme za Vaši objednávku!</h2>
    <p>Zde je obsah Vašeho košíku:</p>
    <table>
    <tr>
    <th>Produkt</th>
    <th>Množství</th>
    <th>Cena za kus</th>
    <th>Celková cena</th>
    </tr>";

    // Iterace přes položky v košíku a přidání informací do e-mailu
    foreach ($_SESSION["cart"] as $item) {
        $total_price = $item['quantity'] * $item['price']; // Spočítáme celkovou cenu pro tuto položku
        $message .= "<tr>";
        $message .= "<td>{$item['product_name']}</td>"; // Nahraďte 'product_name' skutečným názvem produktu
        $message .= "<td>{$item['quantity']}</td>";
        $message .= "<td>{$item['price']} $</td>"; // Nahraďte 'price' skutečnou cenou produktu
        $message .= "<td>{$total_price} $</td>"; // Vložíme spočítanou celkovou cenu
        $message .= "</tr>";
    }

    $message .= "</table>";
    $message .= "<p>Děkujeme za Vaši objednávku!</p>";
    $message .= "</body></html>";

    // Nastavení hlaviček pro HTML e-mail
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Odeslání e-mailu
    mail($email, $subject, $message, $headers);

    // Po odeslání e-mailu smažte obsah košíku ze session
    unset($_SESSION["cart"]);

    // Přesměrování na hlavní stránku, kde může uživatel pokračovat v nákupu
    header("Location: index.php");
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


