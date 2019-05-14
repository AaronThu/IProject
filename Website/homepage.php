<?php
include_once "database.php";
include_once "functies.php";
include_once "header.php";
?>
    <html>
    <body class="background">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="titel">Uitgelicht</h1>
            </div>
        </div>
        <div class="row">
        <?php echo genereerArtikelen($dbh, "SELECT TOP 4 * FROM Voorwerp ORDER BY BeginMoment", "col-md-3") ?>
    </div>
    </div>

    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="titel">Looptijd bijna over</h1>
                </div>
            </div>
            <div class="row">
                <?php echo genereerArtikelen($dbh, "SELECT TOP 2 * FROM Voorwerp ORDER BY Eindmoment", "col-md-6") ?>
            </div>
        </div>
    </div>

    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="titel">Net binnen</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-between flex-wrap">
                <?php echo genereerArtikelen($dbh, "SELECT * FROM Voorwerp ORDER BY BeginMoment", "col-md-3") ?>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/timer.js"></script>

    </body>


    </html>


<?php
include_once "footer.php";?>