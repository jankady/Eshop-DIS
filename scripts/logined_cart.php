<?php
require_once("Utility.php");

if (isset($_POST['addToCart'])) {

    session_start();
    $conn = Utility::connectionDatabase();

    $product_id = $_POST["product_id"];


    $user_id = $_SESSION["user_id"];


// Připravit SQL dotaz s funkcí MAX() pro získání největšího ID z tabulky shopping_cart
    $sql = "SELECT MAX(ID) AS max_id FROM shopping_cart WHERE ID_customer = ?";

// Připravit příkaz pro provedení připraveného SQL dotazu
    $stmt = mysqli_prepare($conn, $sql);
        // Vázat parametr pro ID uživatele na dotaz
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        // Provést dotaz
        mysqli_stmt_execute($stmt);
        // Získat výsledek dotazu
        $result = mysqli_stmt_get_result($stmt);
        // Získat řádek výsledku jako asociativní pole
        $row = mysqli_fetch_assoc($result);
        // Získat největší ID záznamu z tabulky shopping_cart
        $max_id = $row['max_id'];
        // Uzavřít příkaz
        mysqli_stmt_close($stmt);

        // Zde můžete provést další akce s $max_id, například ho využít pro další operace v aplikaci
        echo "Největší ID záznamu v tabulce shopping_cart pro uživatele s ID $user_id je: $max_id";



    // stay on current site using javaScript
//    echo "<script>window.history.go(-1);</script>";
//    exit();
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
//session_start();
//
//// Získání ID produktu a nového množství z formuláře
//$product_id = $_POST['product_id'];
//$new_quantity = $_POST['quantity'];
//
//require_once("Utility.php");
//$conn = Utility::connectionDatabase();
//
//// Získání dostupného množství produktu z databáze
//$sql = "SELECT number_of_products FROM product WHERE ID = $product_id";
//$result = mysqli_query($conn, $sql);
//$row = mysqli_fetch_assoc($result);
//$available_quantity = $row['number_of_products'];
//
//// Pokud je nové množství 0, odebereme položku z košíku
//if ($new_quantity == 0) {
//    foreach ($_SESSION["cart"] as $key => $item) {
//        if ($item['product_id'] == $product_id) {
//            unset($_SESSION["cart"][$key]);
//            break;
//        }
//    }
//
//    if (empty($_SESSION["cart"])) {
//        unset($_SESSION["cart"]);
//    }
//
//} else {
//    // Ověření, zda zadané množství nepřekračuje dostupné množství
//    if ($new_quantity <= $available_quantity) {
//        // Aktualizace množství produktu v session cart
//        foreach ($_SESSION["cart"] as &$item) {
//            if ($item['product_id'] == $product_id) {
//                $item['quantity'] = $new_quantity;
//                break;
//            }
//        }
//    } else {
//        // Pokud zadané množství překračuje dostupné množství, upravíme ho na maximálně dostupné množství
//        $new_quantity = $available_quantity;
//        // Aktualizace množství produktu v session cart
//        foreach ($_SESSION["cart"] as &$item) {
//            if ($item['product_id'] == $product_id) {
//                $item['quantity'] = $new_quantity;
//                break;
//            }
//        }
//    }
//}
//
//// Přesměrování na stejnou stránku (aktualizace)
//header("Location: ../pages/shoppingCart.php");


