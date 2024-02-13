<?php

require("../classes/Users.php");
// session_start();
if (isset($_COOKIE["token"])) {
    $token = $_COOKIE["token"];
    $user_email = new Users();
    $user_email->get_email($token);
}
if (!isset($_COOKIE["token"]) and !isset($_SESSION['userLogin'])) {
    echo "<script>alert('Please login');</script>";
    $script = "<script>location = '../homePage.html';</script>";
    echo $script;
    exit();
}
// if (isset($_SESSION['userLogin'])) {
//     $_SESSION['userLogin'] = NULL;
// }


if (isset($_POST['product_id'])) {
    if (empty($_SESSION['cart'])) {
        $_SESSION['cart'] = [
            $_POST['product_id'] => [
                'qty' => 1,
                'name' => $_POST['product_name'],
                'price' => $_POST['product_price']
            ]
        ];
    } else {
        $item_array = [];
        foreach ($_SESSION['cart'] as $product_id => $data) {
            array_push($item_array, $product_id);
        }
        if (in_array($_POST['product_id'], $item_array)) {
            echo "<script>alert('already added')</script>";
            echo "<script>location=\"user_page.php\"</script>";
        } else {
            $_SESSION['cart'][$_POST['product_id']] = [
                'qty' => 1,
                'name' => $_POST['product_name'],
                'price' => $_POST['product_price']
            ];
        }

    }
}
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.xyz/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


    <style>
        body {
            padding-top: 5rem;
        }

        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .navbar {
            padding: 10px;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <!-- <a class="navbar-brand" href="../user/user_page.php">Store</a> -->
        <?php require('../header/header_page.php') ?>
    </nav>

    <main role="main" class="container">
        <div class="album py-5 bg-light">
            <div class="container">
                <?php
                if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_GET['success'] ?>
                    </div>
                <?php } ?>
                <?php
                if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_GET['error'] ?>
                    </div>
                <?php } ?>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php
                    $data = $display->display_product();
                    foreach ($data as $row) {
                        if ($row['enable_prod'] == 1) { ?>
                            <div class="col" width="300">
                                <div class="card shadow-sm">
                                    <img class="bd-placeholder-img card-img-top" src=<?= $row['img_src'] ?> width="100%"
                                        height="400" role="img" aria-label="Placeholder: Thumbnail"
                                        preserveAspectRatio="xMidYMid slice" focusable="false">
                                    </img>

                                    <div class="card-body">

                                        <h5 class="card-text">
                                            <?= $row['name'] ?>
                                        </h5>
                                        <p class="card-text">Price:
                                            <?= $row['price'] ?>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <form class="btn-group" method="POST">
                                                <input type="hidden" name="product_id" value=<?= $row['id'] ?>></input>
                                                <input type="hidden" name="product_name" value=<?= $row['name'] ?>></input>
                                                <input type="hidden" name="product_price" value=<?= $row['price'] ?>></input>

                                                <?php
                                                if ($row['quantity'] == 0) {
                                                    echo "<button type=\"submit\" disabled class=\"btn btn-sm btn-outline-secondary\">ADD TO
                                                CART</button>";
                                                } else {
                                                    echo "<button type=\"submit\" class=\"btn btn-sm btn-outline-secondary\">ADD TO
                                                CART</button>";
                                                }
                                                ?>
                                            </form>
                                            <small class="text-muted">
                                                <?= $row['storeName'] ?> -
                                                <?= $row['vendor_name'] ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>

    </main><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://cdn.jsdelivr.xyz/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.xyz/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
        </script>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>