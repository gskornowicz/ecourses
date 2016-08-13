<?php
session_start();
require_once "config.php";

if(@isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
{
    header('Location: mainpanel.php');
    exit();
}

include_once "./theme/header.php";
?>

<main>
    <div class="row center-block">
        <div class="col-md-4">
            <form role="form" action="./functions/login.php" method="post">

                <div class="form-group">
                    <label>Login</label>
                    <input type="text" name="login" placeholder="login" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Hasło</label>
                    <input type="password" name="password" placeholder="password" class="form-control" required>
                </div>

                <input class="btn btn-primary" type="submit" name="submit_login" value="Zaloguj się">
                 <?php if(@$_SESSION['login_error'] == true): ?>
                 <div class="alert alert-danger">
                     <strong>Błąd!</strong> Błędny login, hasło lub brak takiego użytkownika.
                 </div>
                 <?php endif; ?>

                <?php if(@$_SESSION['account_created'] == true): ?>
                 <div class="alert alert-success">
                     <strong>Sukces!</strong> Konto zostało stworzone, możesz zalogować się podanymi wcześniej danymi.
                 </div>
                 <?php endif; ?>

            </form>
            <p>Nie posiadasz konta? <a href="registration.php">Zarejestruj się!</a></p>
        </div>
        <div class="col-md-8">
            <img class="img-responsive" src="img/main-ecourses-logo.png" alt="Logo Osadnicy">
            <h2 class="text-right">"Wiem, że nic nie wiem" - Sokrates</h2>
        </div>
    </div>
    <hr>
    <div class="row center-block">
        <div class="col-md-4">
             <h2>O co chodzi?</h2>
            <p>"E-Courses" to demo rozwijanej przeze mnie platformy z kursami online. Pierwszy projekt który stworzyłem od podstaw. Chodziło o naukę PHP, MySQL a przy okazji również podniesienie znajomości HTML5 oraz bootstrapa do szybkiego tworzenia front-endu, na portalu wykorzystałem najczęściej spotykane mechanizmy jak: logowanie, rejestracja, walidacja pól i przesyłanie danych formularzy na back-end. Jest to swego rodzaju portfolio, cały kod dostępny jest do ściągnięcia pod adresem: <a href="https://github.com/gskornowicz/ecourses">https://github.com/gskornowicz/ecourses</a></p>
            <p class="text-right">Autor: Grzegorz Skornowicz</p>
            <a href="https://www.facebook.com/gskornowicz" target="_blank" style="margin-right:2px;" class="btn btn-social-icon btn-facebook pull-right">
            <span class="fa fa-facebook "></span>
            </a>
            <a href="https://plus.google.com/u/0/+GrzegorzSkornowicz" target="_blank" style="margin-right:2px;" class="btn btn-social-icon btn-google pull-right">
            <span class="fa fa-google "></span>
            </a>
            <a href="https://twitter.com/GSkornowicz" target="_blank" style="margin-right:2px;" class="btn btn-social-icon btn-twitter pull-right">
            <span class="fa fa-twitter "></span>
            </a>
            <a href="https://www.linkedin.com/in/grzegorz-skornowicz-983a33ab" target="_blank" style="margin-right:2px;" class="btn btn-social-icon btn-linkedin pull-right">
            <span class="fa fa-linkedin "></span>
            </a>
        </div>
        <div class="col-md-8">
            <h3>Wykorzystane technologie:</h3>
            <ul class="list-group">
                <li class="list-group-item">HTML 5</li>
                <li class="list-group-item">Bootstrap 3</li>
                <li class="list-group-item">PHP 7</li>
                <li class="list-group-item">MySQL</li>
                <li class="list-group-item">GIT</li>
            </ul>
        <h3>Tworzone za pomocą:</h3>
            <ul class="list-group">
                <li class="list-group-item">Środowisko XAMPP Apache + MySQL + phpMyAdmin</li>
                <li class="list-group-item">Edytor - Notepad++</li>
                <li class="list-group-item">Edytor - Brackets</li>
                <li class="list-group-item">Klient FTP - WinSCP</li>
                <li class="list-group-item">Klient Git - GitKraken</li>
            </ul>
        </div>
    </div>
    <hr>
</main>

<?php
// resetting flags
unset($_SESSION['login_error']);
unset($_SESSION['account_created']);
?>

<?php include_once "./theme/footer.php"; ?>





