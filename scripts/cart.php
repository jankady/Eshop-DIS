<?php
if (isset($_POST['addToCart'])) {

    session_start();

    $product_id = $_POST["product_id"];

    if (isset($_SESSION["cart"])) {
        // Check if product is already in cart
        $item_arr_id = array_column($_SESSION["cart"], "product_id");
        if (!in_array($product_id, $item_arr_id)) {
            // Add product to cart array
            $_SESSION["cart"][] = array(
                'product_id' => $product_id
            );
        } else {
            // Product is already in cart, handle this if needed (e.g., display a message)
            echo "Product is already in cart.";
        }
    } else {
        // Create cart array if it doesn't exist
        $_SESSION["cart"] = array(
            array(
                'product_id' => $product_id
            )
        );
    }

    echo "<h2>Cart Array:</h2>";
    print_r($_SESSION["cart"]);
    header("Location: ../pages/product.php ");
}
