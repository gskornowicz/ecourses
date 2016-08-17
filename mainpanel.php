<?php
    session_start();
    require_once "config.php";
    if(@$_SESSION['logged_in'] == false)
    {
       header('Location: index.php'); // if not logged in
       exit();
    }
    include_once "./theme/header.php";
?>

        <main>
            <h1>Panel główny</h1>
            <p>Użytkownik: <?php echo $_SESSION['login']." [ID: ".$_SESSION['id'] ."]"; ?></p>
            <p>PHP session ID: <?php echo session_id(); ?> </p>
            <p>Twój email: <?php echo $_SESSION['email']; ?></p>
        </main>

<?php include_once "./theme/footer.php"; ?>
