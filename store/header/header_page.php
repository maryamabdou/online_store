<?php
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    header("Location:../user/categ_product_page.php?search=$search");
    exit();
}
?>

<!doctype html>
<html lang="en">

<html>
<style>
    .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>

<body>
    <?php
    if ($_SESSION['type'] == "user") {
        echo "<a class=\"navbar-brand\" href=\"../user/user_page.php\">Store</a>";
    } else if ($_SESSION['type'] == "vendor") {
        echo "<a class=\"navbar-brand\" href=\"../vendor/vendor_page.php\">Store</a>";
    }
    ?>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault"
        style="display: flex; justify-content: space-between;">
        <ul class="navbar-nav mr-auto">
            <?php
            $display = new Users();
            $category = $display->display_categories();
            foreach ($category as $categ) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href=""
                        onclick="location='../user/categ_product_page.php?id=<?php echo $categ['id']; ?>'" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $categ['name'] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <?php
                        $sub_category = $display->display_sub_categories($categ['name']);
                        foreach ($sub_category as $sub_categ) { ?>
                            <a class="dropdown-item" href="../user/categ_product_page.php?id=<?php echo $sub_categ['id']; ?>">
                                <?= $sub_categ['name'] ?>
                            </a>
                        <?php } ?>
                    </div>
                </li>
            <?php } ?>
            <form class="form-inline my-2 my-lg-0" action="cart_page.php" method="POST" style="margin-left: 20px;">
                <?php
                if ($_SESSION['type'] == "user") {
                    echo "<button class=\"btn btn-outline-success my-2 my-sm-0\" style=\"margin-left: 10px;\" type=\"submit\"
                name=\"cart\">CART</button>";

                    if (isset($_SESSION['cart'])) {
                        $count = count($_SESSION['cart']);
                        echo "<span id=\"cart_count\"class=\"text-warning\"style=\"margin-left: 10px;\">$count</span>";
                    } else {
                        echo "<span id=\"cart_count\"class=\"text-warning\"style=\"margin-left: 10px;\">0</span>";
                    }
                }
                ?>
            </form>
            <?php
            if ($_SESSION['type'] == "user") {
                echo "<button class=\"btn btn-outline-danger my-2 my-sm-0\" style=\"margin-left: 50px;\" onclick=\"location='../user/order_history.php'\"
                name=\"orders\">Orders</button>";
            } ?>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="POST" action="" style="display: flex; flex-direction: row;">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search"
                style="margin-right: 5px;">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown" style="align-self: flex-end; margin-right: 20px;">
                <a class="nav-link dropdown-toggle" href="" role="button" id="dropdownMenu" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Options</a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                    <a class="dropdown-item" href="../login/change_pass_page.php">
                        Change Pass
                    </a>
                    <a class="dropdown-item" href="../Logout.php">
                        Logout
                    </a>
                </div>
            </li>
        </ul>
        <!-- <form class="form-inline my-2 my-lg-0" action="../Logout.php" method="POST" style="align-self: flex-end;">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" id="logout" name="logout">Logout</button>
        </form> -->
    </div>
</body>

</html>