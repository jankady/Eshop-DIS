
<?php
function getRelativePath($target) {
    $currentPath = dirname($_SERVER['PHP_SELF']);
    $relativePath = trim(str_replace($currentPath, '', $target), '/');
    return $relativePath === '' ? '.' : $relativePath;
}


?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= getRelativePath('index.php'); ?>"><img src="<?= getRelativePath('img/mobile-shopping.png'); ?>" alt="eshop" width="30" height="24"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= getRelativePath('index.php'); ?>">Home</a>
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
                        <li><a class="dropdown-item" href="<?= getRelativePath('pages/product.php'); ?>">Everyting</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?= getRelativePath('pages/contact.php'); ?>">Contact</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
        </div>
    </div>
</nav>

