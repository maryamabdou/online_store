<!-- <!DOCTYPE html>
<html>
  <head>
    <title>Store</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="container">
      <h1>Login</h1>
      <form action="Login.php" method="POST">
        <div class="field">
          <label for="email"> E-mail: </label>
          <input type="email" id="email" name="email" />
        </div>
        <div class="field">
          <label for="password"> Password: </label>
          <input type="password" id="password" name="password" />
        </div>
        <div class="selection">
          <input
            type="radio"
            id="radioAdmin"
            name="radio"
            value="admin"
          /><label>Admin</label>
          <input 
            type="radio" 
            id="radioUser" 
            name="radio" 
            value="user" 
            /><label>User</label
          >
          <input
            type="radio"
            id="radioVendor"
            name="radio"
            value="vendor"
          /><label>Vendor</label>
        </div>
        <div class="button">
          <button type="submit" name="login" class="btn btn-success">
            Login
          </button>
        </div>
      </form>
    </div>
  </body>
  <script>
    if(window.history.replaceState){
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</html>
 -->
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
      margin-bottom: 5px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
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
      <form class="form-signin" action="login.php" method="POST">
        <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72"
          height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <?php
        if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
            <?= $_GET['error'] ?>
          </div>
        <?php } ?>
        <label for="inputLogin" class="sr-only">Email address or phone</label>
        <input name="login" type="text" id="inputLogin" class="form-control" placeholder="Email address or phone" required
          autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me" name="remeber"> Remember me
          </label>
        </div>
        <button class="btn btn-md btn-link" name="forget" id="forget" onclick="location='forget_page.php'">forget password</button>
        <div class="selection">
          <input type="radio" id="radioAdmin" name="radio" value="admin" /><label>Admin</label>
          <input type="radio" id="radioUser" name="radio" value="user" /><label>User</label>
          <input type="radio" id="radioVendor" name="radio" value="vendor" /><label>Vendor</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
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

</body>

</html>