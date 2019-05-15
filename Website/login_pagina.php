<?php
include_once("database.php");
include_once("header.php");
include_once("functies.php");
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="height: 600px;">
    <div class="login-dark" style="background-color: #3a3a3a;height: 601px;">
        <form method="post" style="background-color: #4b4c4d;"action="inlog_systeem.php">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration">
                <h1 style="color: rgb(255,255,255);">Inloggen</h1>
            </div>
            <div class="form-group"><p>Gebruikersnaam</p><input class="form-control" type="" name="Gebruikersnaam" placeholder="Gebruikersnaam"></div>
            <div class="form-group"><p>Wachtwoord</p><input class="form-control" type="password" name="Wachtwoord" placeholder="Wachtwoord"minlength="3"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="inloggen"style="background-color: #ffb357;">Inloggen</button></div><a class="forgot" href="#" style="color: rgb(255,255,255);">Nog geen account?</a></form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>


<?php
include_once("footer.php");