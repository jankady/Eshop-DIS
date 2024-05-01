<?php
require_once("Utility.php");

if (isset($_POST['addToCart'])) {

    // odkazovani do kosiku nebo na produkty pres JAVASCRIPT - pak upravit
    // celkova cena uprava mnozstvi (pocitadlo) - hotovo
    // odstranit z kosiku - hotovo
    // zmena ikony kosiku - hotovo
    // skladem upravit - hotovo
    // "Platba"
    // doplnit databazi

    session_start();
    $conn = Utility::connectionDatabase();

    $product_id = $_POST["product_id"];
    $user_id = $_SESSION["user_id"];

    // Připravit SQL dotaz s funkcí MAX() pro získání největšího ID z tabulky shopping_cart
    $sql_cart = "SELECT MAX(ID) AS max_id FROM shopping_cart WHERE ID_customer = ?";
    $stmt_cart = mysqli_prepare($conn, $sql_cart);
    mysqli_stmt_bind_param($stmt_cart, "i", $user_id);
    mysqli_stmt_execute($stmt_cart);
    $result_cart = mysqli_stmt_get_result($stmt_cart);
    $row_cart = mysqli_fetch_assoc($result_cart);
    $cart_id = $row_cart['max_id'];
    mysqli_stmt_close($stmt_cart);

    // Zkontrolovat, zda záznam s daným ID_product již existuje v tabulce shopping_cart_item
    $sql_check_item = "SELECT * FROM shopping_cart_item WHERE ID_cart = ? AND ID_product = ?";
    $stmt_check_item = mysqli_prepare($conn, $sql_check_item);
    mysqli_stmt_bind_param($stmt_check_item, "ii", $cart_id, $product_id);
    mysqli_stmt_execute($stmt_check_item);
    $result_check_item = mysqli_stmt_get_result($stmt_check_item);

    if (mysqli_num_rows($result_check_item) > 0) {
        // Pokud záznam existuje, aktualizujte množství o 1
        $sql_update_quantity = "UPDATE shopping_cart_item SET quantity = quantity + 1 WHERE ID_cart = ? AND ID_product = ?";
        $stmt_update_quantity = mysqli_prepare($conn, $sql_update_quantity);
        mysqli_stmt_bind_param($stmt_update_quantity, "ii", $cart_id, $product_id);
        mysqli_stmt_execute($stmt_update_quantity);
        mysqli_stmt_close($stmt_update_quantity);
    } else {
        // Pokud záznam neexistuje, vložte nový záznam s množstvím 1
        $sql_add_item = "INSERT INTO shopping_cart_item (ID_cart, ID_product, quantity) VALUES (?, ?, 1)";
        $stmt_add_item = mysqli_prepare($conn, $sql_add_item);
        mysqli_stmt_bind_param($stmt_add_item, "ii", $cart_id, $product_id);
        mysqli_stmt_execute($stmt_add_item);
        mysqli_stmt_close($stmt_add_item);
    }

    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../index.php"); // If no referring page, redirect to index.php
    }
    exit();
}

if (isset($_POST['removeFromCart'])) {
    $conn=Utility::connectionDatabase();
    session_start();
    // Získání ID produktu z formuláře
    $product_id = $_POST['product_id'];

    // Získání ID uživatele z session
    $user_id = $_SESSION['user_id'];

    // Příprava SQL dotazu pro odstranění produktu z košíku uživatele
    $sql_remove_product = "DELETE FROM shopping_cart_item WHERE ID_product = ? AND ID_cart IN (SELECT ID FROM shopping_cart WHERE ID_customer = ?)";

    echo"produkt:". $product_id;
    echo " user:".$user_id;
    // Příprava a provedení dotazu
    $stmt_remove_product = mysqli_prepare($conn, $sql_remove_product);
    mysqli_stmt_bind_param($stmt_remove_product, "ii", $product_id, $user_id);
    mysqli_stmt_execute($stmt_remove_product);

    // Zavřít přípravek
    mysqli_stmt_close($stmt_remove_product);

    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../index.php"); // If no referring page, redirect to index.php
    }
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


