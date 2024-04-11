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

    // Checking duplicate data for username, phone_number, and email
    $sql_duplicate_check = "SELECT COUNT(*) AS count FROM customer WHERE e_mail = ? OR tel_num = ? OR username = ?";
    $stmt_duplicate_check = mysqli_prepare($conn, $sql_duplicate_check);
    mysqli_stmt_bind_param($stmt_duplicate_check, "sss", $email, $phone_number, $username);
    mysqli_stmt_execute($stmt_duplicate_check);
    $result_duplicate_check = mysqli_stmt_get_result($stmt_duplicate_check);
    $row_duplicate_check = mysqli_fetch_assoc($result_duplicate_check);
    $count_duplicate_check = $row_duplicate_check['count'];
    mysqli_stmt_close($stmt_duplicate_check);

    if (!$count_duplicate_check > 0) {
        // If no duplicate found, proceed with insertion

        // Check if the address already exists
        $sql_address_check = "SELECT ID FROM address WHERE city = ? AND street = ? AND postal_code = ? AND house_number = ? AND ID_country = ?";
        $stmt_address_check = mysqli_prepare($conn, $sql_address_check);
        mysqli_stmt_bind_param($stmt_address_check, "ssssi", $city, $street, $postal_code, $house_number, $country);
        mysqli_stmt_execute($stmt_address_check);
        $result_address_check = mysqli_stmt_get_result($stmt_address_check);

        if (mysqli_num_rows($result_address_check) > 0) {
            // If address exists, get its ID
            $row_address = mysqli_fetch_assoc($result_address_check);
            $address_id = $row_address['ID'];
        } else {
            // If address doesn't exist, insert it and get its ID
            $stmt_insert_address = mysqli_prepare($conn, "INSERT INTO address (city, street, postal_code, house_number, ID_country) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt_insert_address, "ssssi", $city, $street, $postal_code, $house_number, $country);
            mysqli_stmt_execute($stmt_insert_address);
            $address_id = mysqli_insert_id($conn); // Get the ID of the newly inserted address
            mysqli_stmt_close($stmt_insert_address);
        }
        mysqli_stmt_close($stmt_address_check);

        // Insert customer using the existing or newly inserted address
        $stmt_insert_customer = mysqli_prepare($conn, "INSERT INTO customer (name, surname, e_mail, tel_num, password, username, ID_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_insert_customer, "sssissi", $firstname, $lastname, $email, $phone_number, $password_hash, $username, $address_id);
        mysqli_stmt_execute($stmt_insert_customer);
        mysqli_stmt_close($stmt_insert_customer);
        mysqli_close($conn);
        header('Location: ../pages/login.php');
    }

    else{
        // Handle duplicate user data
        $duplicate_message = "";

        $sql_duplicate_email_check = "SELECT * FROM customer WHERE e_mail = ?";
        $stmt_duplicate_email_check = mysqli_prepare($conn, $sql_duplicate_email_check);
        mysqli_stmt_bind_param($stmt_duplicate_email_check, "s", $email);
        mysqli_stmt_execute($stmt_duplicate_email_check);
        $result_duplicate_email_check = mysqli_stmt_get_result($stmt_duplicate_email_check);
        if (mysqli_num_rows($result_duplicate_email_check) > 0) {
            $duplicate_message .= "Emailová adresa je již použita. ";
        }
        mysqli_stmt_close($stmt_duplicate_email_check);

        $sql_duplicate_phone_check = "SELECT * FROM customer WHERE tel_num = ?";
        $stmt_duplicate_phone_check = mysqli_prepare($conn, $sql_duplicate_phone_check);
        mysqli_stmt_bind_param($stmt_duplicate_phone_check, "s", $phone_number);
        mysqli_stmt_execute($stmt_duplicate_phone_check);
        $result_duplicate_phone_check = mysqli_stmt_get_result($stmt_duplicate_phone_check);
        if (mysqli_num_rows($result_duplicate_phone_check) > 0) {
            $duplicate_message .= "Telefonní číslo je již použito. ";
        }
        mysqli_stmt_close($stmt_duplicate_phone_check);

        $sql_duplicate_username_check = "SELECT * FROM customer WHERE username = ?";
        $stmt_duplicate_username_check = mysqli_prepare($conn, $sql_duplicate_username_check);
        mysqli_stmt_bind_param($stmt_duplicate_username_check, "s", $username);
        mysqli_stmt_execute($stmt_duplicate_username_check);
        $result_duplicate_username_check = mysqli_stmt_get_result($stmt_duplicate_username_check);
        if (mysqli_num_rows($result_duplicate_username_check) > 0) {
            $duplicate_message .= "Uživatelské jméno je již použito.";
        }
        mysqli_stmt_close($stmt_duplicate_username_check);

        echo "<script>alert('{$duplicate_message}'); window.location='../pages/registration.php';</script>";
    }
}

if (isset($_POST["login_submit"])) {
    // Zpracování přihlášení uživatele
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $password = $_POST['password'];
        $login_identity = mysqli_real_escape_string($conn, $_POST['username']); // Uživatelské jméno nebo email

        // Vyhledání uživatele podle uživatelského jména nebo emailu
        $sql_login = "SELECT * FROM customer WHERE username = ? OR e_mail = ?";
        $stmt_login = mysqli_prepare($conn, $sql_login);
        mysqli_stmt_bind_param($stmt_login, "ss", $login_identity, $login_identity);
        mysqli_stmt_execute($stmt_login);
        $result_login = mysqli_stmt_get_result($stmt_login);

        if (mysqli_num_rows($result_login) == 1) {
            // Uživatel nalezen
            $user = mysqli_fetch_assoc($result_login);
            if (password_verify($password, $user['password'])) {
                // Heslo je správné, přihlášení uživatele
                echo "Přihlášen";
                //header('Location: ../pages/index.php'); // Přesměrování na úvodní stránku po přihlášení
                exit();
            } else {
                // Neplatné heslo
                echo "<script>alert('Neplatné heslo.'); window.location='../pages/login.php';</script>";
                exit();
            }
        } else {
            // Uživatel nenalezen
            echo "<script>alert('Uživatel nenalezen.'); window.location='../pages/login.php';</script>";
            exit();
        }
    }
}
?>