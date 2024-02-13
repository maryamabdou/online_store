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

// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";
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
        <?php require('../header/header_page.php') ?>
    </nav>

    <main role="main" class="container">
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php
                    foreach ($_SESSION['cart'] as $product_id => $data) {
                        $info = $display->get_product_info($product_id);
                        foreach ($info as $row) {
                            ?>
                            <div class="col" width="50">
                                <div class="card shadow-sm">
                                    <img class="bd-placeholder-img card-img-top" src=<?= $row['img_src'] ?> width="100%"
                                        height="400" role="img" aria-label="Placeholder: Thumbnail"
                                        preserveAspectRatio="xMidYMid slice" focusable="false">
                                    </img>

                                    <div class="card-body">

                                        <h5 class="card-text">
                                            <?= $data['name'] ?>
                                        </h5>
                                        <p class="card-text">Price:
                                            <?= $data['price'] ?>
                                        </p>
                                    </div>
                                    <form class="counter" method="POST" style="display: flex; flex-direction: row; justify-content: center;
                                                align-items: center;">
                                        <button type="submit" formaction="inc_dec.php" class="btn btn-warning my-2 my-sm-0"
                                            name="increment" value="+" style="width: 45px; text-align:center;">+</button>
                                        <input type="hidden" name="product_id" value=<?= $product_id ?>></input>
                                        <input type="hidden" name="left_quantity" value=<?= $row['quantity'] ?>></input>
                                        <input type="text" class="form-control" name="prod_quantity"
                                            style="width: 45px; text-align:center;" value=<?= $data['qty'] ?>></input>
                                        <button type="submit" formaction="inc_dec.php" class="btn btn-warning my-2 my-sm-0"
                                            name="decrement" value="-" style="width: 45px; text-align:center;">-</button>
                                    </form>
                                    <form class="btn-group" method="POST" action="cart.php">
                                        <input type="hidden" name="product_id" value=<?= $product_id ?>></input>
                                        <button class="btn btn-md btn-primary btn-block" type="submit"
                                            style="margin-top: 15px;">REMOVE</button>
                                    </form>
                                </div>
                            </div>
                        <?php }
                    } ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h7>
                                    <?php
                                    $total = 0;
                                    foreach ($_SESSION['cart'] as $product_id => $data) {
                                        $total += ($data['qty'] * $data['price']);
                                        // <?= $data['name'] . "  => " . $data['qty'] . "<br>"
                                    } ?>
                                </h7>
                                <h5 class="card-text" style="margin-top: 10px;">
                                    Total Price:
                                    <?= $total ?>
                                </h5>
                            </div>
                            <form class="btn-group" method="POST" action="order.php">
                                <input type="hidden" name="total" value=<?= $total ?>></input>
                                <button type="submit" class="btn btn-md btn-primary btn-block" style="margin-top: 10px;">ORDER</button>
                            </form>
                        </div>
                    </div>
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