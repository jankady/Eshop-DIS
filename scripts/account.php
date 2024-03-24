<?php
require_once("Utility.php");

$conn = Utility::connectionDatabase();

if (isset($_POST["registration_submit"])) {

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
    $house_number = $_POST['house_number'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];


//checking duplicite data in address
    $sql = "SELECT * FROM address WHERE city = ? AND street = ? AND postal_code = ? AND house_number = ? AND ID_country = ?"; //dodelat split na ulici a č. p.

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $city, $street, $postal_code, $house_number, $country);
    mysqli_stmt_execute($stmt);


    $result = mysqli_stmt_get_result($stmt);

    if (!mysqli_num_rows($result) > 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO address (city, street, postal_code, house_number,ID_country) VALUES (?, ?, ?, ?, ?)");

        // Bind values to the statement
        mysqli_stmt_bind_param($stmt, "ssssi", $city, $street, $postal_code, $house_number, $country);


        // Execute the statement
        mysqli_stmt_execute($stmt);

        //get ID of new created row
        $address_id = mysqli_stmt_insert_id($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($conn, "INSERT INTO customer (name, surname, e_mail, tel_num, password, username, ID_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssissi", $firstname, $lastname, $email, $phone_number, $password_hash, $username, $address_id);

        mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('Location: ../pages/login.php');

    } else {

        //write duplicite row ID
        $row = mysqli_fetch_assoc($result);
        $duplicate_id = $row['ID'];
        echo $duplicate_id;
        mysqli_stmt_close($stmt);

        mysqli_close($conn);
//    header('Location: ../pages/registration.php');
    }
}
?>
