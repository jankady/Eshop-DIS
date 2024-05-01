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

    mysqli_close($conn);
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

    mysqli_close($conn);
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../index.php"); // If no referring page, redirect to index.php
    }
    exit();

}

if(isset($_POST['product_id'], $_POST['quantity'])) {
    // Získání ID aktuálně přihlášeného uživatele z relace
    session_start();
    if(isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];

        $conn = Utility::connectionDatabase();

        // Přijměte data z formuláře
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        if($quantity == 0) {
            // Pokud je množství 0, odstraňte produkt z nákupního košíku
            $sql_delete_item = "DELETE FROM shopping_cart_item WHERE ID_cart = (SELECT MAX(ID) FROM shopping_cart WHERE ID_customer = ?) AND ID_product = ?";
            $stmt_delete_item = mysqli_prepare($conn, $sql_delete_item);
            mysqli_stmt_bind_param($stmt_delete_item, "ii", $user_id, $product_id);
            mysqli_stmt_execute($stmt_delete_item);
            mysqli_stmt_close($stmt_delete_item);
        } else {
            // Zkontrolujte počet dostupných produktů v databázi
            $sql_check_availability = "SELECT number_of_products FROM product WHERE ID = ?";
            $stmt_check_availability = mysqli_prepare($conn, $sql_check_availability);
            mysqli_stmt_bind_param($stmt_check_availability, "i", $product_id);
            mysqli_stmt_execute($stmt_check_availability);
            $result_check_availability = mysqli_stmt_get_result($stmt_check_availability);
            $row_check_availability = mysqli_fetch_assoc($result_check_availability);
            $available_quantity = $row_check_availability['number_of_products'];
            mysqli_stmt_close($stmt_check_availability);

            // Pokud je požadované množství větší než počet dostupných produktů, upravte ho na maximální dostupné množství
            if($quantity > $available_quantity) {
                $quantity = $available_quantity;
            }

            // Získání nejvyššího ID nákupního košíku pro daného uživatele
            $sql_cart = "SELECT MAX(ID) AS max_id FROM shopping_cart WHERE ID_customer = ?";
            $stmt_cart = mysqli_prepare($conn, $sql_cart);
            mysqli_stmt_bind_param($stmt_cart, "i", $user_id);
            mysqli_stmt_execute($stmt_cart);
            $result_cart = mysqli_stmt_get_result($stmt_cart);
            $row_cart = mysqli_fetch_assoc($result_cart);
            $cart_id = $row_cart['max_id'];
            mysqli_stmt_close($stmt_cart);

            // Aktualizace množství pouze u konkrétního produktu v nákupním košíku
            $sql_update_quantity = "UPDATE shopping_cart_item SET quantity = ? WHERE ID_cart = ? AND ID_product = ?";
            $stmt_update_quantity = mysqli_prepare($conn, $sql_update_quantity);
            mysqli_stmt_bind_param($stmt_update_quantity, "iii", $quantity, $cart_id, $product_id);
            mysqli_stmt_execute($stmt_update_quantity);
            mysqli_stmt_close($stmt_update_quantity);
        }

        mysqli_close($conn);
        // Přesměrování zpět na stránku s nákupním košíkem
        header("Location: ../pages/shoppingCart.php");
        exit();
    } else {
        // Pokud uživatel není přihlášen, mělo by se nějakým způsobem ošetřit, co se stane, například přesměrováním na přihlašovací stránku
        header("Location: ../pages/login.php");
        exit();
    }
}
