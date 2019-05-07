<?

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>EenmaalAndermaal</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/bootstrap/css/Navigation-with-Button-1.css">
    <link rel="stylesheet" href="assets/bootstrap/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/bootstrap/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/bootstrap/css/styles.css">

</head>

<body>
<div>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="homepage.php">EenmaalAndermaal</a>
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span
                        class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                 id="navcol-1">
                <ul class="nav navbar-nav d-flex justify-content-center align-items-center mr-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">Veilingen</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">Over Ons</a></li>
                    <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown"
                                                     aria-expanded="false" href="#">Rubrieken</a>
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">First
                                Item</a><a class="dropdown-item" role="presentation" href="#">Second Item</a><a
                                    class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                    </li>
                </ul>
                <form class="form-inline mr-auto" target="_self">
                    <div class="form-group"><label for="search-field"><i class="fa fa-search"></i></label><input
                                class="form-control search-field" type="search" id="search-field" name="search"></div>
                </form>
                <span class="d-flex justify-content-center align-items-center navbar-text actions"> <a class="login"
                                                                                                       href="login_pagina.php">Inloggen</a><a
                            class="btn btn-light action-button" role="button" href="registreren_emailpagina.php">Registreer</a></span>
            </div>
        </div>
    </nav>
</div>


<?php if (!empty($_SESSION['foutmelding'])) {
   echo '<div class="foutmelding inputforms">
    <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center"> We wijzen je graag op het
        volgende:</h5>
    <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst">'; echo $_SESSION['foutmelding'] . '</h5>
</div>';
    $_SESSION['foutmelding'] = "";
} ?>

