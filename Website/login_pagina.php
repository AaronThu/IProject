<?php
include_once("includes/database.php");
include_once("includes/header.php");
include_once "includes/functies.php";
?>
<div class = "loginpagina">
    <div class="login-dark" style="background-color: #3a3a3a;height: 601px;">
        <form method="post" style="background-color: #4b4c4d;" action="inlog_systeem.php">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration">
                <h1 style="color: rgb(255,255,255);">Inloggen</h1>
            </div>
            <div class="form-group"><p>Gebruikersnaam</p><input class="form-control" type="text" name="Gebruikersnaam" placeholder="Gebruikersnaam"></div>
            <div class="form-group"><p>Wachtwoord</p><input class="form-control" type="password" name="Wachtwoord" placeholder="Wachtwoord" minlength="3"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="inloggen" style="background-color: #ffb357;">Inloggen</button></div><a class="forgot" href="http://iproject2.icasites.nl/registreren_emailpagina.php" style="color: rgb(255,255,255);">Nog geen account?</a><a class = "forgot" href= "#"> Wachtwoord vergeten? </a></form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</div>
<?php
include_once("includes/footer.php");
?>