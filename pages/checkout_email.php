<?php
require_once ("../scripts/sessions.php");
SessionClass::checkSessions();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../img/shop.ico">
    <link rel="stylesheet" href="../style/styleTesting.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Eshop</title>

</head>
<body>
<?php

require_once("../components/nav.php");

?>
<div class="container-fluid text-center" >

    <h2>Zadejte váš e-mail pro potvrzení objednávky:</h2>
    <form action="../scripts/unlogined_cart.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <input type="submit" name="submit_email" value="Odeslat">
    </form>
</div>

<?php
require_once ("../components/footer.php");
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>
</html>