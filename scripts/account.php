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

    $country = $_POST['country'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $postal_code =  $_POST['postal_code'];


    // Prepare the SQL statements
    $stmt = mysqli_prepare($conn, "INSERT INTO address (city, street, postal_code, house_number,ID_country) VALUES (?, ?, ?, ?, ?)");

// Bind values to the statement
    mysqli_stmt_bind_param($stmt, "ssssi", $city, $street, $postal_code, $street, $country);  // Replace "" with your house number logic

// Execute the statement
    mysqli_stmt_execute($stmt);

// Close the statement
    mysqli_stmt_close($stmt);

// Insert customer with the address ID
//    $customer_sql = "INSERT INTO customer (name, surname, e_mail, password, username, tel_num, ID_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
//    $stmt_customer = mysqli_prepare($conn, $customer_sql);
//    mysqli_stmt_bind_param($stmt_customer, "sssssss", $firstname, $lastname, $email, $password_hash, $username, $phone_number, $address_id);
//    mysqli_stmt_execute($stmt_customer);

    mysqli_close($conn);
}
?>
