<?php
    echo "<div class='alert alert-info'>";

    echo "Debugowanie włączone<br>";
    echo "FLAGS:<br>";
    echo "login_already_in_database = ".@$_SESSION['login_already_in_database']."<br>";
    echo "email_already_in_database = ".@$_SESSION['email_already_in_database']."<br>";
    echo "bad_password_retype = ".@$_SESSION['bad_password_retype']."<br>";
    echo "bad_login = ".@$_SESSION['bad_login']."<br>";
    echo "bad_password = ".@$_SESSION['bad_password'] ."<br>";
    echo "account_created = ".@$_SESSION['account_created'] ."<br>";

    //echo "GLOBAL VARS:<br>";

    echo "</div> ";
?>
