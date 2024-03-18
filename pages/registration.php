<?php
require_once("../scripts/sessions.php");
SessionClass::checkSessions();

?>
<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../img/shop.ico">
    <!--    <link rel="stylesheet" href="../style/styleTesting.css">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Eshop</title>
</head>
<body>
<?php
require_once("../components/nav.php");
?>

<!-- Formulář pro registraci -->
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="text-center">
                <h2>Registace</h2>
            </div>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="text-center">
                    <h4>Kontaktní údaje</h4>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Telefonní číslo</label>
                    <input type="phone_number" class="form-control" id="phone_number" name="phone_number" required>
                </div>
                <div class="mb-3">
                    <label for="firstname" class="form-label">Jméno</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Příjmení</label>
                    <input type="lastname" class="form-control" id="lastname" name="lastname" required>
                </div>
                <div class="text-center">
                    <h4>Registrační údaje</h4>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Uživatelské jméno</label>
                    <input type="username" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Heslo</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="text-center">
                    <h4>Fakturační údaje</h4>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Stát</label>
                    <select id="country" name="country" class="form-control" required>
                        <!--                       databaze jiříku :)-->
                        <!-- :( -->
                    </select>

                </div>
                <div class="mb-3">
                    <label for="street" class="form-label">Ulice a č. p.</label>
                    <input type="street" class="form-control" id="street" name="street" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">Město</label>
                    <input type="city" class="form-control" id="city" name="city" required>
                </div>
                <div class="mb-3">
                    <label for="postal_code" class="form-label">PSČ</label>
                    <input type="postal_code" class="form-control" id="postal_code" name="postal_code" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Registrovat</button>

                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once("../components/footer.php");
?>

<!-- Obsah pro patičku HTML -->
</body>
</html>
