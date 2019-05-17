<?php
session_Start();
include_once('includes/functies.php');
include_once('includes/database.php');
$headerEmailPagina = "Location: http://iproject2.icasites.nl/verstuurmail.php";
$_SESSION['Emailadres'] = "";
$_SESSION['emailErr'] = "";

if (isset($_POST['verstuurmail'])) {
   $_SESSION['Emailadres'] = test_invoer($_POST['Emailadres']);
   $tellingemailadres = vergelijkloginwaarde("Emailadres", $_SESSION['Emailadres'], $dbh);

    if (empty($_SESSION['Emailadres'])) {
        $_SESSION['foutmelding'] = "Email is verplicht";
    } elseif ($tellingemailadres != 0) {
        $_SESSION['foutmelding'] = "Dit email-adres is al in gebruik";
    } elseif (filter_var($_SESSION['Emailadres'], FILTER_VALIDATE_EMAIL) == false) {
        $_SESSION['foutmelding'] = "Vul een correct geformuleerd email-adres in";
    } else {
        header($headerEmailPagina);
    }
}


include_once("includes/header.php");
?>
<link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
<body style="height: 600px;">
    <div class="login-dark" style="background-color: #3a3a3a;height: 601px;">
        <form method="post" style="background-color: #4b4c4d;"action="verstuurmail.php">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration">
                <h2 style="color: rgb(255,255,255);">Registreren</h2>
          
            </div>
            
            <div class="form-group"><p>E-mailadres</p><input class="form-control" type="email" name="email" placeholder="E-mailadres"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="registreren"style="background-color: #ffb357;">Registreren</button></div>
            <p> U ontvangt een verificatielink </p>
            <p class = "disclaimer"> Uw e-mailadres wordt niet opgeslagen in onze database</p>
            
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
<?php include_once("includes/footer.php");?>