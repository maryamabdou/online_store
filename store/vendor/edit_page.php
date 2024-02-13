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

if (isset($_POST['product_id'])) {

}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Store</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .navbar {
            padding: 10px;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="text"] {
            margin-bottom: 5px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="file"] {
            margin-bottom: 5px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin select {
            margin-bottom: 5px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.xyz/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <?php require('../header/header_page.php') ?>
    </nav>
    <main>
        <div class="text-center">
            <!-- <form class="form-signin" method="POST" action="" enctype="multipart/form-data"> -->
            <h1 class="h3 mb-3 font-weight-normal">EDIT PRODUCT</h1>
            <?php
            if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_GET['error'] ?>
                </div>
            <?php } ?>
            <?php
            if (isset($_GET['prod_id'])) {
                $product_id = $_GET['prod_id'];
            } ?>
            <form class="form-signin" method="POST" action="change_price.php">
                <input type="hidden" name="product_id" id="product_id" value=<?php if (isset($_GET['prod_id'])) {
                    $product_id = $_GET['prod_id'];
                    echo $product_id;
                } ?>></input>
                <label for="inputPrice" class="sr-only">Price</label>
                <input name="price" type="text" id="inputPrice" class="form-control" placeholder="Price">
                <button class="btn btn-md btn-primary btn-block" type="submit" formaction="change_price.php">Change
                    Price</button>
            </form>
            <form class="form-signin" method="POST" action="change_quantity.php">
                <input type="hidden" name="product_id" id="product_id" value=<?php if (isset($_GET['prod_id'])) {
                    $product_id = $_GET['prod_id'];
                    echo $product_id;
                } ?>></input>
                <label for="inputQty" class="sr-only">Quantity</label>
                <input name="quantity" type="text" id="inputQty" class="form-control" placeholder="Quantity">
                <button class="btn btn-md btn-primary btn-block" type="submit">Change
                    Quantity</button>
            </form>
            <form class="form-signin" method="POST" action="change_photo.php" enctype="multipart/form-data">
                <input type="hidden" name="product_id" id="product_id" value=<?php if (isset($_GET['prod_id'])) {
                    $product_id = $_GET['prod_id'];
                    echo $product_id;
                } ?>></input>
                <label class="sr-only">Select image to upload</label>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <button class="btn btn-md btn-primary btn-block" type="submit">Change
                    Photo</button>
            </form>
            <!-- </form> -->
        </div>
</body>
</main>
<footer>
    <!-- place footer here -->
</footer>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.xyz/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

<script src="https://cdn.jsdelivr.xyz/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

</body>

</html>