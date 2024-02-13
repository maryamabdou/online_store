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

    .form-signin input[type="email"] {
      margin-bottom: px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    .form-signin input[type="text"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }
  </style>
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.xyz/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
  <main>
    <div class="text-center">
      <?php
      if (isset($_GET['success'])) { ?>
        <div class="alert alert-success" role="alert">
          <?= $_GET['success'] ?>
        </div>
      <?php } ?>
      <form class="form-signin" action="signup.php" method="POST">
        <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72"
          height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
        <?php
        if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
            <?= $_GET['error'] ?>
          </div>
        <?php } ?>
        <label for="inputName" class="sr-only">Name</label>
        <input name="name" type="text" id="inputName" class="form-control" placeholder="Name" required autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="conf_inputPassword" class="sr-only">Confirm Password</label>
        <input name="conf_password" type="password" id="conf_inputPassword" class="form-control" placeholder="Password"
          required>
        <label for="inputPhone" class="sr-only">Phone</label>
        <input name="phone" type="text" id="inputPhone" class="form-control" placeholder="Phone" required>
        <div class="selection" name="selection">
          <input type="radio" id="radioUser" name="radio" value="user"
            onclick="handleRadioClick();" /><label>User</label>
          <input type="radio" id="radioVendor" name="radio" value="vendor"
            onclick="handleRadioClick();" /><label>Vendor</label>
        </div>
        <div class="vendor_info" id="vendor_info" style="display: none">
          <label for="inputId" class="sr-only">National ID</label>
          <input name="id" type="text" id="inputId" class="form-control" placeholder="National ID">
          <label for="inputStoreName" class="sr-only">Store Name</label>
          <input name="storeName" type="text" id="inputStoreName" class="form-control" placeholder="Store Name">
          <label for="inputTax" class="sr-only">Tax No</label>
          <input name="tax" type="text" id="inputTax" class="form-control" placeholder="Tax No">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
      </form>
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

<script>
  const vendor_info = document.getElementById('vendor_info');

  function handleRadioClick() {
    if (document.getElementById('radioVendor').checked) {
      vendor_info.style.display = 'block';
    } else {
      vendor_info.style.display = 'none';
    }
  }

</script>
</body>

</html>