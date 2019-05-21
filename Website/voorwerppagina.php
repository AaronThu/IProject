<?php
include_once("includes/header.php");
include_once("includes/functies.php");

$voorwerpID = 0;
if (!isset($_GET["voorwerpID"])) {
    return;
}
$voorwerpID = test_invoer($_GET["voorwerpID"]);
if (!is_numeric($voorwerpID)) {
    return;
}
$voorwerpEigenschappen = GetVoorwerpEigenschappen($voorwerpID);
?>

<body>
    <div class = "voorwerppagina" style = "background-color:#3a3a3a;">
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="carousel slide" data-ride="carousel" id="carousel-1">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active"><img class="w-100 d-block" src="assets/img/<?php echo GetVoorwerpFoto($voorwerpID); ?>" alt="Slide Image"></div>
                            <div class="carousel-item"><img class="w-100 d-block" src="assets/img/Veilinghamer.jpg" alt="Slide Image"></div>
                            <div class="carousel-item"><img class="w-100 d-block" src="assets/img/Veilinghamer.jpg" alt="Slide Image"></div>
                        </div>
                        <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button"
                                data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-1" data-slide-to="1"></li>
                            <li data-target="#carousel-1" data-slide-to="2"></li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col">
                            <p class="titel"><?php echo strtoupper(GetProductNaam($voorwerpID));?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex flex-column" style="height: 60%;">
                            <p class="bieden" style="margin: 0%0%0%;">Tijd om te bieden:</p>
                            <p class="Timer" data-time="<?php echo $voorwerpEigenschappen[0]['Eindmoment']?>">
                            <div>
                                <form class="d-flex flex-row">
                                    <input class="form-control d-flex flex-row" type="text" style="margin: 0%0%20%;">
                                    <button class="btn btn-primary" type="button" style="background-color: #a9976a;height: 5%;">Bied</button>
                                </form>
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
                        <p class="verkooplocatie" style="margin: 0%20%;"><?php echo $value['Gebruikersnaam'];?></p>
                    </div>
                    <div class="d-flex flex-row">
                        <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Locatie: </p>
                        <p class="verkooplocatie" style="margin: 0%22%;"><?php echo $value['Plaatsnaam'];?></p>
                    </div>
                    <div class="d-flex flex-row">
                        <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Betalingswijze: </p>
                        <p class="verkooplocatie" style="margin: 0%13%;"><?php echo $value['Betalingswijze'];?></p>
                    </div>
                    <div class="d-flex flex-column">
                        <p class="flex-wrap verkooplocatie" style="font-size: 100%;width: 100%;">Beschrijving:</p>
                        <p class="verkooplocatie" style="width: 100%;"><?php echo $value['Beschrijving'];?><br><br><br></p>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-md-6 bieden">
                    <p class="biedgeschiedenis" style="height: 0%;margin: 0%0%0%;"><?php foreach (GetBieders($voorwerpID) as $key => $value) { ?>
                        <div class="d-flex flex-row justify-content-between">
                        <p class="d-flex flex-column justify-content-between" style="width: 10%;"><?php echo $value['Gebruikersnaam'];?></p>
                        <p class="d-flex flex-row justify-content-between" style="width: 10%;"><?php echo $value['BodTijd'];?></p>
                        <p class="d-flex flex-row justify-content-between" style="width: 10%;"><?php echo $value['BodBedrag'];?></p>
                    </div>
                    <?php } ?></p>
                    <div class="d-flex flex-row justify-content-between">
                        <p class="d-flex flex-column justify-content-between" style="width: 10%;">Naam</p>
                        <p class="d-flex flex-row justify-content-between" style="width: 10%;">Datetime</p>
                        <p class="d-flex flex-row justify-content-between" style="width: 10%;">Bedrag</p>
                    </div>
                    
                    <div class="flex-row">
                        <p class="anderenbekekenook">Anderen bekeken ook</p>
                        <?php foreach (GetMeestBekeken() as $key => $value) { ?>
                            <a href="voorwerppagina.php?voorwerpID=<?php echo $value['Voorwerpnummer'] ;?>"><img src="assets/img/<?php echo $value['Filenaam']; ?>" width="300" heigth="300"/></a><br><br>
                        <?php } ?>
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