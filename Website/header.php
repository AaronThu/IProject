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
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button-1.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/styles.css">

</head>

<body>
    <!-- Start: Navigation with Button -->
    <div>
        <nav class="navbar navbar-light navbar-expand-md sticky-top navigation-clean-button">
            <div class="container">
                <div><a class="navbar-brand" href="#">EenmaalAndermaal</a><span>Klik Klik Klaar</span></div><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle
                        navigationdd</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav d-flex justify-content-center align-items-center mr-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="#">Veilingen</a></li>
                        <li class="nav-item" role="presentation"></li>
                        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Rubrieken</a>
                            <div class="dropdown-menu flex-column" role="menu">
                                <h6 class="dropdown-header" role="presentation">Populair</h6><a class="dropdown-item" role="presentation">Categorie 1</a><a class="dropdown-item" role="presentation">Categorie 2</a><a class="dropdown-item" role="presentation">Categorie 3</a>
                                <div class="dropdown-divider" role="presentation"></div>
                                <h6 class="dropdown-header" role="presentation">Categories</h6>
                                <div class="container flex-nowrap flex-sm-nowrap flex-md-wrap flex-lg-wrap flex-xl-wrap">
                                    <a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie's</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a>
                                    <a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a>
                                    <a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a><a class="dropdown-item" href="#">Categorie</a></div>
                                <div class="dropdown-divider" role="presentation"></div><a class="dropdown-item" role="presentation" href="#">Alle Categories</a>
                            </div>
                        </li>
                    </ul>
                    <form class="form-inline mr-auto" target="_self">
                        <div class="form-group"><label for="search-field"><i class="fa fa-search"></i></label><input class="form-control search-field" type="search" id="search-field" name="search"></div>
                    </form><span class="d-flex justify-content-center align-items-center navbar-text actions"> <a class="login" href="#">Inloggen</a><a class="btn btn-light action-button" role="button" href="#">Registreer</a></span><span class="d-none justify-content-center align-items-center navbar-text" id="user"> <a class="btn btn-light action-button" role="button" href="#">Uitloggen</a></span>
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