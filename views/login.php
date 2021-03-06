<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Panel logowania</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://bootswatch.com/4/simplex/bootstrap.min.css">-->

    <!-- Custom styles for this template -->
    <link href="<?php echo ROOT_URL;?>/assets/css/singin.css" rel="stylesheet">
</head>

<body class="text-center">
<form method="POST" class="form-signin">
    <img class="mb-4" src="http://www.cpe-powereng2016.utp.edu.pl/wp-content/uploads/2015/05/pl_UTP_godlo.png" alt="" width="256" height="256">
    <h1 class="h3 mb-3 font-weight-normal">Panel logowania</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input name="email" type="text" id="inputEmail" class="form-control" placeholder="Email" value="" required>
    <label for="inputPassword" class="sr-only">Hasło</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="*******" value="" required>
    <input class="btn btn-lg btn-primary btn-block" name="submit" type="submit" value="Zaloguj się">
    <br>
    <?php Helpers::displayMessage(); ?>
    <p class="mt-5 mb-3 text-muted">&copy; Przemysław Swakowski 2019</p>
</form>
</body>
</html>
