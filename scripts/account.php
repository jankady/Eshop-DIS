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
    $postal_code = $_POST['postal_code'];


// Close the statement


    $sql = "SELECT * FROM address WHERE city = ? AND street = ? AND postal_code = ? AND house_number = ? AND ID_country = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $city, $street, $postal_code, $street, $country);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!mysqli_num_rows($result) > 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO address (city, street, postal_code, house_number,ID_country) VALUES (?, ?, ?, ?, ?)");

        // Bind values to the statement
        mysqli_stmt_bind_param($stmt, "ssssi", $city, $street, $postal_code, $street, $country);  // Replace "" with your house number logic

        // Execute the statement
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        header('Location: ../pages/login.php');

    }
    mysqli_stmt_close($stmt);

    mysqli_close($conn);
    header('Location: ../pages/registration.php');

}
?>
