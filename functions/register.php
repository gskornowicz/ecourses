<?php
session_start();
require_once "../config.php";

if(@isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
{
    header('Location: ./mainpanel.php');
    exit();
}


// assigning post variables
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$retype_password = $_POST['retype_password'];
$rules = $_POST['rules'];

//recaptcha 2.0
// if enabled do:
if($recaptcha_enabled == true)
{
    $captcha_check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']); // $secret key is in config.php
    $answer = json_decode($captcha_check);

    // setting up failed flag if recaptcha failed
    if($answer->success == false)
    {
        $_SESSION['recaptcha_failed'] = true;
    }
}

// POST data check
//// check login for length and special characters
if(strlen($login)<3 || strlen($login)>23 || !ctype_alnum($login))
{
    $_SESSION['bad_login'] = true;
}

// check email with regular expression (if it has xxx@domain.pl)
if(preg_match("/^[a-z0-9](\.?[a-z0-9_-]){0,}@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/", $email) === false)
{
    $_SESSION['bad_email'] = true;
}

// check password for at least 6 characters long and lesss than 64
if(strlen($password)<6 || strlen($password)>64)
{
    $_SESSION['bad_password'] = true;
}

// check retype of password
if($password != $retype_password)
{
    $_SESSION['bad_password_retype'] = true;
}


// connection to DB and checking for duplication in login or email
try
{
    $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

    // if connection had error, throw exception
    if($db_connection->connect_errno!=0)
    {
        throw new Exception("EXCEPTION: Error number: ".mysqli_connect_errno()." Error message: ".mysqli_connect_error());
    }
    else
    {
        // check if login or email are not already in database
        if(mysqli_num_rows($result = $db_connection->query(sprintf("SELECT id FROM users WHERE login='%s'",
                                                                   mysqli_real_escape_string($db_connection,$login))))>0)
        {
            $_SESSION['login_already_in_database'] = true;
        }
        if(mysqli_num_rows($result = $db_connection->query(sprintf("SELECT id FROM users WHERE email='%s'",
                                                                    mysqli_real_escape_string($db_connection,$email))))>0)
        {
            $_SESSION['email_already_in_database'] = true;
        }
    }

}
catch(Exception $error)
{
    error_log($error->getMessage(), 0);
    exit("Database error, please report this to admin and try again later");
}




// if anything was wrong with registration, go back to registration form!
if(isset($_SESSION['bad_password_retype']) ||
            isset($_SESSION['recaptcha_failed']) ||
            isset($_SESSION['bad_login']) ||
            isset($_SESSION['bad_email']) ||
            isset($_SESSION['bad_password']) ||
            isset($_SESSION['login_already_in_database']) ||
            isset($_SESSION['email_already_in_database']))
{
    header('Location: ../registration.php');
}
else
{
    //if no earlier error has been encountered, insert post form data into database
    try
    {
        //default hash password before inserting into database
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        //database sanitised insert
        if($db_connection->query(sprintf("INSERT INTO users (`id`, `loginn`, `password`, `email`) VALUES (NULL, '%s', '%s', '%s')",
                                    mysqli_real_escape_string($db_connection,$login),
                                    mysqli_real_escape_string($db_connection,$password),
                                    mysqli_real_escape_string($db_connection,$email))))
        {
            //on success, flag account created and go to login form
            $_SESSION['account_created'] = true;
            header('Location: ../index.php');
        }
        else
        {
            // if not succeded, throw exception
            throw new Exception("EXCEPTION: Error number: ".mysqli_errno($db_connection)." Error message: ".mysqli_error($db_connection));
        }


    }
    catch(Exception $error)
    {
        error_log($error->getMessage(), 0);
        exit("Database error, please report this to admin and try again later");
    }

}

mysqli_close($db_connection);
