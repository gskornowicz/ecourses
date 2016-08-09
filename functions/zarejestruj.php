<?php
session_start();
require_once "../config.php";

if(@isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
{
    header('Location: ./panelglowny.php');
    exit();
}

$login = $_POST['login']; // max 3-23 characters
$email = $_POST['email'];
$password = $_POST['password'];
$retype_password = $_POST['retype_password'];
$rules = $_POST['rules'];

// sanity, converting special HTML charcters to HTML entities
$login = htmlentities($login, ENT_QUOTES, "UTF-8");

// POST data check
//// check login
if(strlen($login)<3 OR strlen($login)>23)
{
    $_SESSION['bad_login'] = true;
}

//TODO:
//// check email (if it has xxx@domain.pl)

////check password for at least 8 characters strong (preferably in the future check for strong password)
if(strlen($password)<8)
{
    $_SESSION['bad_password'] = true;
}

/// check retype of password
if($password != $retype_password)
{
    $_SESSION['bad_password_retype'] = true;
}


$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

// check if login or email are not already in database
if(mysqli_num_rows($result = $db_connection->query(sprintf("SELECT * FROM users WHERE login='%s'",mysqli_real_escape_string($db_connection,$login))))>0)
{
    $_SESSION['login_already_in_database'] = true;
}

if(mysqli_num_rows($result = $db_connection->query(sprintf("SELECT * FROM users WHERE email='%s'",
         mysqli_real_escape_string($db_connection,$email))))>0)
{
    $_SESSION['email_already_in_database'] = true;
}

if(isset($_SESSION['bad_password_retype']) or
            isset($_SESSION['bad_login']) or
            isset($_SESSION['bad_password']) or
            isset($_SESSION['login_already_in_database']) or
            isset($_SESSION['email_already_in_database']))
{
    header('Location: rejestracja.php');
}
else
{
   if($db_connection->query(sprintf("INSERT INTO users (`id`, `login`, `password`, `email`) VALUES (NULL, '%s', '%s', '%s')",
                                mysqli_real_escape_string($db_connection,$login),
                                mysqli_real_escape_string($db_connection,$password),
                                mysqli_real_escape_string($db_connection,$email))))
   {
       $_SESSION['account_created'] = true;
        header('Location: ../index.php');
   }
    else
    {
        echo "db error";
    }

}

mysqli_close($db_connection);

?>
