<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once "database.php";
include_once "databaseFunctions.php";
include_once 'beheerder/logica/databaseFuncties.php';
$adminKnop = "";
$verkoperRegistratieKnop = "";
$notificatieknop = "";


$zoekbalk = '<form class="form-inline mr-auto" target="_self" action = "zoekresultatenpagina.php">
<div class="form-group"><label for="search-field"><i class="fa fa-search"></i></label><input class="form-control search-field" type="search" id="search-field" name="zoekterm"></div>
</form>';

if (empty($_SESSION['Gebruikersnaam'])) {
    $loginKnop = '<a class="login" href="login_pagina.php">Inloggen</a>';
    $registratieKnop = '<a class="btn btn-light action-button" href="registreren_emailpagina.php">Registeren</a>';
} else {
    $loginKnop = '<a class="login" href="uitlog_pagina.php">Uitloggen</a>';
    $registratieKnop = '<a class="btn btn-light action-button" href="account_pagina.php">Mijn Account</a>';

    $notificaties = GetNotificaties($_SESSION['GebruikersID']);

    $aantalNotificaties = count($notificaties);

    $notificatieknop = '<div class="notificaties">' . $aantalNotificaties . '</div>';

    if (IsAdmin($_SESSION["Gebruikersnaam"])) {
        $adminKnop = '<a class="btn btn-light action-button" href="beheerder/beheerder_homepagina.php">Admin Paneel</a>';
    }
    if ($_SESSION['SoortGebruiker'] == 'koper') {
        $verkoperRegistratieKnop = '<a class="btn btn-light action-button" href="registreren_verkoper.php">Registreren verkoper</a>';
    } elseif (isset($_SESSION['VerkoperStatus']) && $_SESSION['VerkoperStatus'] == 'aanvraging') {
        $verkoperRegistratieKnop = '<a class="btn btn-light action-button" href="registratie_verkopers_code.php">registratiecode invullen</a>';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>EenmaalAndermaal</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="/assets/css/Navigation-with-Button-1.css">
    <link rel="stylesheet" href="/assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="/assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/Rubriek.css">
    <link rel="stylesheet" href="/assets/css/Breadcrum.css">
    <link rel="stylesheet" href="/assets/css/Subrubrieken.css">
    <link rel="stylesheet" href="/assets/css/Sorting-Box.css">
    <link rel="stylesheet" href="/assets/css/Account-Pagina.css">
    <link rel="icon" href="/assets/img/EenmaalAndermaal_Logo.png">

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
    <!-- Start: Navigation with Button -->
    <div>
        <nav class="navbar navbar-light navbar-expand-md sticky-top navigation-clean-button" style="height: 5em;">
            <div class="container">
                <div><a class="navbar-brand" href="index.php">EenmaalAndermaal</a><span>Klik Klik Klaar</span></div><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigationdd</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav d-flex justify-content-center align-items-center mr-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="#">Veilingen</a></li>
                        <li class="nav-item" role="presentation"></li>
                        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Rubrieken</a>
                            <div class="dropdown-menu flex-column" role="menu">
                                <h6 class="dropdown-header" role="presentation">Populair</h6>
                                <?php
                                foreach (GetRubriekenPopulair(3) as $key => $value) {
                                    print("<a class=\"dropdown-item\" role=\"presentation\" href=\"/subrubrieken_pagina.php?rubriekID=$value[Rubrieknummer]\">$value[Rubrieknaam]</a>");
                                }
                                ?>
                                <div class="dropdown-divider" role="presentation"></div>
                                <h6 class="dropdown-header" role="presentation">Rubrieken</h6>
                                <div class="container flex-nowrap flex-sm-nowrap flex-md-wrap flex-lg-wrap flex-xl-wrap">
                                    <?php
                                    foreach (GetRubrieken(-1) as $key => $value) {
                                        print("<a class=\"dropdown-item\" href=\"/subrubrieken_pagina.php?rubriekID=$value[Rubrieknummer]\">$value[Rubrieknaam]</a>");
                                    }
                                    ?>
                                </div>
                                <div class="dropdown-divider" role="presentation"></div><a class="dropdown-item" role="presentation" href="rubrieken.php">Alle rubrieken</a>
                            </div>
                        </li>
                    </ul>
                    <?php echo $zoekbalk; ?>
                    <span class="d-flex justify-content-center align-items-center navbar-text actions">
                        <?php
                        echo $loginKnop;
                        echo $verkoperRegistratieKnop;
                        echo $adminKnop;
                        echo $registratieKnop;
                        echo $notificatieknop;
                        ?>
                    </span>
                </div>
            </div>
        </nav>
    </div>
    <!-- End: Navigation with Button -->
    <?php if (!empty($_SESSION['foutmelding'])) {
        echo '<div class="foutmelding inputforms">
    <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center"> We wijzen je graag op het
        volgende:</h5>
    <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst">';
        echo $_SESSION['foutmelding'] . '</h5>
</div>';
        $_SESSION['foutmelding'] = "";
    } ?>