<?php

include_once "includes/functies.php";
include_once "includes/database.php";

$locatieFouteLink = "Location: index.php";

if (empty($_SESSION['Gebruikersnaam'])) {
    $_SESSION['foutmelding'] = "Log in om voorwerpen te kunnen verkopen!";
    header($locatieFouteLink);
    return;
}

if (!IsVerkoper($_SESSION['Gebruikersnaam'])) {
    $_SESSION['foutmelding'] = "Maak een verkopers account om voorwerpen te kunnen verkopen!";
    header($locatieFouteLink);
    return;
}
include_once "includes/header.php";
?>

<div class="d-flex flex-column">
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center" style="color: white;">Product verkopen</h2>
                </div>
            </div>
            <!-- verkoop_systeem.php -->
            <form method="post" action="" enctype="multipart/form-data">
                <div class="verkooppaginarow">
                    <div class="col-md-6 verkooppagina">
                        <p class="verkoophead"> Product specificaties </p>
                        <h6>Titel van je product</h6>
                        <input type="text" class="form-control inputforms" name="titel" required>

                        <h6>Afbeelding(en) van je product</h6>
                        <input type="file" class="form-control inputforms" name="bestand" required>
                        <h6>Beschrijving van je product</h6>
                        <textarea rows=4 cols=50 class="form-control inputforms" name="beschrijving" required></textarea>

                    </div>
                    <div class="col-md-6 verkooppagina">
                        <p class="verkoophead"> Prijs specificaties</p>
                        <h6>Startprijs</h6>
                        <input type="number" class="form-control inputforms" name=startprijs required>

                        <h6>Betalingswijze</h6>
                        <select class="form-control inputforms" name="betalingswijze">
                            <option value='iDeal' selected>iDeal</option>
                            <option value='Creditcard'>Creditcard</option>
                        </select>
                        <h6>Betalingsinstructies</h6>
                        <input type="text" class="form-control inputforms" name="betalingsinstructies">
                    </div>
                    <div class="col-md-6 verkooppagina">
                        <p class="verkoophead"> Overige specificaties</p>
                        <h6>Looptijd</h6>
                        <select class="form-control inputforms" name="looptijd">
                            <option value="1">1 dag</option>
                            <option value="3">3 dagen</option>
                            <option value="5">5 dagen</option>
                            <option value="7" selected>7 dagen</option>
                            <option value="9">9 dagen</option>
                        </select>
                        <h6>Locatie</h6>
                        <input type=text class="form-control inputforms" name="locatie" required>
                        <h6> Verzendinstructies</h6>
                        <input type="text" class="form-control inputforms" name="verzendinstructies">
                    </div>

                    <div class="col-md-6 verkooppagina">
                        <p class="verkoophead"> Selecteer rubriek</p>
                        <?php genereerRubriekenDropdown(-1, "parentrubriek") ?>
                    </div>

                </div>
        </div>
        <div class="text-center" style="margin: 20px;">
            <button class="btn btn-primary" type="submit" style="background-color: #a9976a;" name="veilen">Start veiling</button>
        </div>
    </div>
</div>
<div class="spacing">
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/utils.js"></script>
<script src="assets/js/rubriekenDropdown.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</body>


<?php
include_once "includes/footer.php";
?>