<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php"><img src="./img/mobile-shopping.png" alt="eshop" width="30"
                                                        height="24"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                        require_once("scripts/nav-category.php");
                        $nav = new Nav_category();
                        $nav->nav();

                        ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Everyting</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="./pages/contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
