<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />

    <title>Platforma "E-Courses" - Kursy online za darmo</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="./theme/bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="./theme/bootstrap/css/bootstrap-theme.min.css" >
    <link rel="stylesheet" type="text/css" href="./theme/bootstrap/bootstrap-social-gh-pages/bootstrap-social.css" >
    <!-- Font Awesome   -->
    <link rel="stylesheet" type="text/css" href="./theme/fontawesome/css/font-awesome.min.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body>
<div class="container">
    <header>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
                <img src="./img/main-ecourses-logo.png" alt="Logo E-" height="30">
            </div>
            <ul class="nav navbar-nav">
              <li><a class="active" href="index.php">Logowanie</a></li>
              <li><a href="registration.php">Rejestracja</a></li>
              <li><a href="mainpanel.php">Panel główny</a></li>
            </ul>

            <?php if(@isset($_SESSION['logged_in'])): ?>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="./functions/logout.php">Wyloguj się</a></li>
            </ul>
            <?php endif; ?>

          </div>
        </nav>
    </header>
