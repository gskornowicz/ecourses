<?php
session_start();
session_regenerate_id(true);
require_once "../config.php";

if(@isset($_SESSION['logged_in']) && @$_SESSION['logged_in'] == true)
{
    header('Location: ./panelglowny.php');
    exit();
}

// security measure checking if login and password was transmited using form
if(isset($_POST['login']) && isset($_POST['password']))
{



    // Connecting, selecting database
    $db_connection = @new mysqli("$db_host", "$db_user", "$db_password","$db_name");
    if($db_connection->connect_errno!=0)
    {
        echo "DB con error: ".$db_connection->connect_errno;
    }
    else
    {
        // main check login function
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");

        if($result = $db_connection->query(
        sprintf("SELECT * FROM users WHERE login='%s' AND password='%s'",
        mysqli_real_escape_string($db_connection,$login),
        mysqli_real_escape_string($db_connection,$password))))
        {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
            $_SESSION['login'] = $row['login'];
            $_SESSION['email'] = $row['email'];
            $result_password = $row['password'];
            $result->close();

            if($result_password == $password && $_SESSION['login'] == $login)
            {
                $_SESSION['logged_in'] = true;
                header('Location: ../panelglowny.php');
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
