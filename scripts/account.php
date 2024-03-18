<?php
require_once("DBconnect.php");

$conn = DBconnect::connectionDatabase();

if (isset($_POST["registration_submit"])) {
    // Error handling for database connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize user input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // Hash the password securely before storing it
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Use a strong hashing algorithm

    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);

    // Prepare the SQL statements
    $address_sql = "INSERT INTO address (street, city, postal_code) VALUES ( ?, ?, ?)";
    $stmt_address = mysqli_prepare($conn, $address_sql);
    mysqli_stmt_bind_param($stmt_address, "sss", $street, $city, $postal_code);
    mysqli_stmt_execute($stmt_address);

// Get the inserted address ID
    $address_id = mysqli_stmt_insert_id($stmt_address);

// Insert customer with the address ID
    $customer_sql = "INSERT INTO customer (name, surname, e_mail, password, username, tel_num, ID_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_customer = mysqli_prepare($conn, $customer_sql);
    mysqli_stmt_bind_param($stmt_customer, "sssssss", $firstname, $lastname, $email, $password_hash, $username, $phone_number, $address_id);
    mysqli_stmt_execute($stmt_customer);

    mysqli_close($conn);
}
?>
