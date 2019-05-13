<?php
session_Start();
include_once('functies.php');
include_once('database.php');
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


include_once("header.php");
?>

<body class="background">

<main style="min-height: 52.5vh;margin-right: 10vw;margin-left: 10vw;">
    <div class="container text-center" style="padding: 4em;">
        <h2 style="margin: 1ex;color: #ffffff;">Registreren</h2>
        <form style="width: 100%;padding: 2em;" method="post" action="registreren_emailpagina.php">
            <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center" >Vul jouw email-adres in*</h5>
            <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"></h5>
            <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
                 style="margin: 1em 0em;"><input
                        class="form-control inputforms" type="text" name="Emailadres" id="Emailadres" placeholder="Email"></div>
            <button class="btn btn-primary text-center registratieKnop" data-bs-hover-animate="pulse" type="submit" name="verstuurmail">Registreer
            </button>
        </form>
    </div>
</main>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-animation.js"></script>
</body>
<?php include_once("footer.php");?>