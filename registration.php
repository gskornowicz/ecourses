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
        <div class="col-md-12">
            <h1>Rejestracja konta na platformie "E-Courses"</h1>
        </div>
    </div>

    <div class="row center-block">
        <div class="col-md-4">

            <h2>Wypełnij formularz:</h2>
            <form role="form" action="./functions/register.php" method="post">

                <div class="form-group <?php if(@$_SESSION['login_already_in_database'] == true || @$_SESSION['bad_login'] == true): ?>has-error<?php endif; ?>">
                    <label>Login:</label>
                    <input type="text" class="form-control" name="login" required>
                    <?php if(@$_SESSION['login_already_in_database'] == true): ?>
                     <div class="alert alert-danger">
                      <strong>Błąd!</strong> Ten login jest zajęty, proszę wybierz inny.
                    </div>
                    <?php endif; ?>
                    <?php if(@$_SESSION['bad_login'] == true): ?>
                     <div class="alert alert-danger">
                      <strong>Błąd!</strong> Login musi mieć od 3 do 23 znaków alfanumerycznych. (czyt. bez !@#$%^ oraz ogonków ąęśćź itd)
                    </div>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php if(@$_SESSION['email_already_in_database'] == true || $_SESSION['bad_email'] == true   ): ?>has-error<?php endif; ?>" >
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" required>
                     <?php if(@$_SESSION['email_already_in_database'] == true): ?>
                     <div class="alert alert-danger">
                      <strong>Błąd!</strong> Ten adres email jest już powiązany z kontem, proszę podaj inny adres.
                    </div>
                    <?php endif; ?>
                     <?php if(@$_SESSION['bad_email'] == true): ?>
                     <div class="alert alert-danger">
                      <strong>Błąd!</strong> niepoprawny adres email. Musisz podać adres email w formacie login@domena.xyz
                    </div>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php if(@$_SESSION['bad_password'] == true): ?>has-error<?php endif; ?>" >
                    <label>Hasło:</label>
                    <input type="password" class="form-control" name="password" required>
                     <?php if(@$_SESSION['bad_password'] == true): ?>
                     <div class="alert alert-danger">
                      <strong>Błąd!</strong> Hasło musi posiadać przynajmniej 6 i nie więcej niż 64 znaków.
                     </div>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php if(@$_SESSION['bad_password_retype'] == true): ?>has-error<?php endif; ?>" >
                    <label>Powtórz Hasło:</label>
                    <input type="password" class="form-control" name="retype_password" required>
                    <?php if(@$_SESSION['bad_password_retype'] == true): ?>
                     <div class="alert alert-danger">
                      <strong>Błąd!</strong> Źle przepisane hasło, spróbuj ponownie.
                     </div>
                    <?php endif; ?>
                </div>

                <div class="checkbox">
                    <label><input type="checkbox" class="checkbox-inline" name="rules" required>akceptuję regulamin</label>
                </div>

                <div class="g-recaptcha" data-sitekey="<?php echo $public_key; ?>"></div> <!-- sitekey need to be changed outside dev env -->
                 <?php if(@$_SESSION['recaptcha_failed'] == true): ?>
                     <div class="alert alert-danger">
                      <strong>Błąd!</strong> Błąd captchy, spróbuj jeszcze raz :)
                     </div>
                    <?php endif; ?>

                <input type="submit" value="Zarejestruj się" class="btn btn-primary">
            </form>
        </div>
        <div class="col-md-8">
        </div>
    </div>
</main>

<?php
//resetting flags
unset($_SESSION['login_already_in_database']);
unset($_SESSION['email_already_in_database']);
unset($_SESSION['bad_password_retype']);
unset($_SESSION['bad_login']);
unset($_SESSION['bad_email']);
unset($_SESSION['bad_password']);
unset($_SESSION['account_created']);
unset($_SESSION['recaptcha_failed']);
?>
<?php include_once "./theme/footer.php"; ?>
