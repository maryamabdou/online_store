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


if (isset($_POST['enable_product'])) {
    $product_id = $_POST['product_id'];
    $enable = $_POST['enable_prod'];
    if ($enable == 1) {
        $enable = 0;
    } else {
        $enable = 1;
    }
    $check = new Users();
    $check->enable_prod($product_id, $enable);
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

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <?php require('../header/header_page.php') ?>
    </nav>

    <main role=" main" class="container">
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
                    $display = new Users();
                    $data = $display->display_vendor_products();
                    foreach ($data as $row) { ?>
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
                                    <p class="card-text">Quantity:
                                        <?= $row['quantity'] ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted" style="display: flex; flex-direction: row;">
                                            <form method="POST" action="">
                                                <input type="hidden" name="product_id" id="product_id" value=<?= $row['id'] ?>></input>
                                                <input type="hidden" name="enable_prod" id="enable_prod"
                                                    value=<?= $row['enable_prod'] ?>></input>
                                                <?php
                                                if ($row['enable_prod'] == 1) {
                                                    echo "<button class=\"btn btn-secondary my-2 my-sm-0\" type=\"submit\" name=\"enable_product\">Disable</button>";
                                                } else {
                                                    echo "<button class=\"btn btn-primary my-2 my-sm-0\" type=\"submit\" name=\"enable_product\">Enable</button>";
                                                }
                                                ?>
                                            </form>
                                            <form method="POST" action="edit_page.php?prod_id=<?=$row['id']?>">
                                                <!-- <input type="hidden" name="product_id" id="product_id" value=<?= $row['id'] ?>></input> -->
                                                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit"
                                                    name="enable_product" style="margin-left: 10px;" onclick="Location='edit_page.php?prod_id'">Edit</button>
                                            </form>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>


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