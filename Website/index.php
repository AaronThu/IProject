<?php
include_once "includes/database.php";
include_once "includes/functies.php";
include_once "includes/header.php";
if (empty($_SESSION['Gebruikersnaam'])) {
    include_once "includes/banner.php";
}

?>
    <body class="background">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="titel">Uitgelichte voorwerpen</h2>
            </div>
        </div>
        <div class="row">
            <?php echo genereerArtikelen($dbh, "SELECT TOP 4 * FROM Voorwerp WHERE VeilingGesloten = 0 ORDER BY BeginMoment", "col-md-3") ?>
        </div>
    </div>
    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="titel">Exclusieve voorwerpen</h2>
                </div>
            </div>
            <div class="row">
                <?php echo genereerArtikelen($dbh, "SELECT TOP 2 * FROM Voorwerp WHERE Startprijs >=5000 AND VeilingGesloten = 0 ORDER BY Startprijs desc", "col-md-6") ?>
            </div>
        </div>
    </div>
    
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="titel">Looptijd bijna over</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-between flex-wrap">
                <?php echo genereerArtikelen($dbh, "SELECT TOP 12 * FROM Voorwerp WHERE VeilingGesloten = 0 ORDER BY Eindmoment asc", "col-md-3") ?>
            </div>
        </div>
    </div>


    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="titel">Rubrieken</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-between flex-wrap">
                <?php echo genereerCatogorie($dbh, "SELECT TOP 4 * FROM Rubriek WHERE Parent_Rubriek = -1 ", "col-md-3") ?>
            </div>
        </div>
    </div>

    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="titel">Middenklasse voorwerpen</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-between flex-wrap">
                <?php echo genereerArtikelen($dbh, "SELECT TOP 6 * FROM Voorwerp WHERE Startprijs <5000 AND Startprijs > 1000  AND VeilingGesloten = 0 ORDER BY Startprijs desc ", "col-md-3") ?>
            </div>
        </div>
    </div>


    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/timer.js"></script>
    

    </body>





<?php
include_once "includes/footer.php";?>