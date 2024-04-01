<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../pages/index.php"><img src="../img/mobile-shopping.png" alt="eshop" width="30"
                                                               height="24"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../pages/index.php">Home</a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link " href="../pages/product.php?page=1&sort_by=1">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../pages/contact.php">Contact</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (isset($_SESSION["cart"])) {
                    ?>
                    <li><a href="../pages/shoppingCart.php"><img src="../img/shopCart2.png" alt="">

                        </a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li><a href="../pages/shoppingCart.php"><img src="../img/shopCart1.png" alt="">
                        </a></li>

                    <?php
                }
                ?>

                <li><a href="../pages/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <li><a href="../pages/registration.php"><span class="glyphicon glyphicon-log-in"></span> Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

