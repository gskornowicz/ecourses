<?php
session_start();
session_regenerate_id(true);
require_once "../config.php";

if(@isset($_SESSION['logged_in']) && @$_SESSION['logged_in'] == true)
{
    header('Location: ./mainpanel.php');
    exit();
}

// security measure checking if login and password was transmited using form
if(isset($_POST['login']) && isset($_POST['password']))
{



    // Connecting, selecting database
    $db_connection = @new mysqli("$db_host", "$db_user", "$db_password","$db_name");

    //main login function start
    if($db_connection->connect_errno!=0)
    {
        echo "DB con error: ".$db_connection->connect_errno;
    }
    else
    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        // if query returns more than 0 rows with submited password and login, allow login in + query sanitisation
        if(mysqli_num_rows($result = $db_connection->query(
        sprintf("SELECT * FROM users WHERE login='%s'",
        mysqli_real_escape_string($db_connection,$login))))>0)
        {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
            $_SESSION['login'] = $row['login'];
            $_SESSION['email'] = $row['email'];
            $result->close();

            //if provided password hash equals database hash: set logged in flag and goto main menu
            if(password_verify($password, $row['password'] ))
            {
                $_SESSION['logged_in'] = true;
                header('Location: ../mainpanel.php');
            }
            else
            {
                $_SESSION['login_error'] = true;
                header('Location: ../index.php');
            }

        }
        else
        {
            $_SESSION['login_error'] = true;
            header('Location: ../index.php');
        }

        $db_connection->close();
    }



}

else
{
    header('Location: ../index.php');
}

?>
