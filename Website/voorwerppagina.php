<?php
include_once("includes/header.php");
include_once("includes/functies.php");
include_once("includes/databaseFunctions.php");
include_once("includes/database.php");


$voorwerpID = 0;
if (!isset($_GET["voorwerpID"])) {
    return;
}
$voorwerpID = test_invoer($_GET["voorwerpID"]);
if (!is_numeric($voorwerpID)) {
    return;
}

$voorwerpEigenschappen = GetVoorwerpEigenschappen($voorwerpID);

if(empty($voorwerpEigenschappen[0]['Verkoopprijs'])){
    $BiedingsPrijs = $voorwerpEigenschappen[0]['Startprijs'] + MinimaleBiedPrijs($voorwerpEigenschappen[0]['Startprijs']);
} else{
    $BiedingsPrijs = $voorwerpEigenschappen[0]['Verkoopprijs'] + MinimaleBiedPrijs($voorwerpEigenschappen[0]['Verkoopprijs']);
}



?>

    <body>
    <div class="voorwerppagina" style="background-color:#3a3a3a;">
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="carousel slide" data-ride="carousel" id="carousel-1">
                            <div class="carousel-inner" role="listbox">
                                <?php
                                foreach (GetVoorwerpFoto($voorwerpID) as $key => $value){
                                if ($key == 0) {
                                    echo "<div class=\"carousel-item active\">";

                                } else {
                                    echo "<div class=\"carousel-item\">";

                                } ?>
                                <img class="w-100 d-block voorwerppaginaimg"
                                     src="http://iproject2.icasites.nl/pics/<?php echo $value['FileNaam']; ?>"
                                     alt="<?php $value['FileNaam']?>"></div>
                            <?php } ?>

                        </div>
                        <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span
                                        class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a
                                    class="carousel-control-next" href="#carousel-1" role="button"
                                    data-slide="next"><span class="carousel-control-next-icon"></span><span
                                        class="sr-only">Next</span></a>
                        </div>
                        <ol class="carousel-indicators">
                            <?php foreach (GetVoorwerpFoto($voorwerpID) as $key => $value) {
                                if ($key == 0) {
                                    echo "<li data-target=\"#carousel-1\" data-slide-to=\"$key\" class=\"active\"></li>";

                                } else {
                                    echo "<li data-target=\"#carousel-1\" data-slide-to=\"$key\"></li>";

                                }
                            } ?>


                        </ol>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col">
                            <p class="titel"><?php echo strtoupper(GetProductNaam($voorwerpID)); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex flex-column" style="height: 60%;">
                            <p class="bieden" style="margin: 0%0%5%;">Tijd om te bieden:</p>
                            <p class="Timer" data-time="<?php echo $voorwerpEigenschappen[0]['Eindmoment'] ?>">
                            <div>
                                <?php
                                if(isset($_SESSION['GebruikersID'])) { ?>
                                <form class="d-flex flex-row" action="bied_systeem.php?voorwerpID=<?php echo $voorwerpID; ?>" method="post">
                                    <input class="form-control d-flex flex-row" style="margin: 0%0%20%;" type="number" step=0.01 name="bodbedrag" value="<?php echo $BiedingsPrijs; ?>">
                                    <button class="btn btn-primary" type="submit" style="background-color: #a9976a;height: 5%;">Bied</button>
                                </form>
                                <?php }
                                else { ?>
                                <p class="d-flex flex-row">
                                    <input class="form-control d-flex flex-row" style="margin: 0%0%20%;" placeholder="Log in om mee te bieden!" type="number" step="0.01">
                                    <button class="btn btn-primary" disabled="disabled" style="background-color: #a9976a;height: 5%;">Bied</button>
                                </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 voorwerpinfo"><?php foreach ($voorwerpEigenschappen as $key => $value) { ?>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie">Verkoper: </p>
                            <p class="verkooplocatie" style="margin: 0%19.5%;"><?php echo $value['Gebruikersnaam']; ?></p>
                        </div>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie">Feedback: </p>
                            <p class="verkooplocatie" style="margin: 0%19.5%;"><?php echo GetFeedbackVoorVerkoper($dbh, $value['VerkopersID']); ?></p>
                        </div>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Locatie: </p>
                            <p class="verkooplocatie" style="margin: 0%22%;"><?php echo $value['Plaatsnaam']; ?></p>
                        </div>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Startprijs: </p>
                            <p class="verkooplocatie" style="margin: 0%20%;">€<?php echo $value['Startprijs']; ?></p>
                        </div>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Betalingswijze: </p>
                            <p class="verkooplocatie" style="margin: 0%13%;"><?php echo $value['Betalingswijze']; ?></p>
                        </div>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Betalingsinstructie: </p>
                            <p class="verkooplocatie" style="margin: 0%7.5%;"><?php echo $value['Betalingsinstructie']; ?></p>
                        </div>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Verzendinstructie: </p>
                            <p class="verkooplocatie" style="margin: 0%9%;"><?php echo $value['Verzendinstructies']; ?></p>
                        </div>
                        <div class="d-flex flex-column">
                            <?php
                            if(empty($value['Beschrijving'])){
                               echo '<p>Dit product heeft geen beschrijving</p>';
                            } else{
                                echo '<p class="flex-wrap verkooplocatie" style="font-size: 100%;width: 100%;">Beschrijving:</p>';
                                 echo ' <iframe class="voorwerpBeschrijving" src="voorwerp_beschrijving.php" ></iframe>';
                                $_SESSION['Beschrijving'] = $value['Beschrijving'];
                            }
                            ?>

                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-6 bieden">
                <div class="d-flex flex-row justify-content-between" >
                    <p>Naam</p>
                    <p>Tijd</p>
                    <p>Bedrag</p>
                </div>
                    <p class="biedgeschiedenis" style="height: 0%;margin: 0%0%0%;"><?php foreach (GetBieders($voorwerpID) as $key => $value) { ?>
                <div class="d-flex flex-row justify-content-between">
                    <p class="d-flex flex-column justify-content-between" style="width: 10%;"><?php echo $value['Gebruikersnaam']; ?></p>
                    <p class="d-flex flex-row justify-content-between" style="width: 10%;"><?php echo $value['BodTijd']; ?></p>
                    <p class="d-flex flex-row justify-content-between" style="width: 10%;"><?php echo $value['BodBedrag']; ?></p>
                </div>
                <?php } ?>
                <div class="float-right" style="margin-top: 10em">
                    <p class="meervanVerkoper">Meer van deze verkoper</p>
                    <?php foreach (GetMeerVanVerkoper($voorwerpID) as $key => $value) { ?>
                        <a href="voorwerppagina.php?voorwerpID=<?php echo $value['Voorwerpnummer']; ?>"><img
                                    src="http://iproject2.icasites.nl/pics/<?php echo $value['FileNaam']; ?> alt = "<?php echo $value['Voorwerpnummer'];?>"
                                    class = "meervanverkoperimg"/></a><br><br>
                    <?php } 
                    if(empty($value['Filenaam']) && empty($value['Voorwerpnummer'])) {
                        echo "<p>Deze verkoper heeft geen andere advertenties.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/timer.js"></script>
    </body>

<?php

include_once("includes/footer.php");
?>
