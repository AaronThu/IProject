<?php
include_once("header.php");
include_once("database.php");


?>



<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Homepage poging 2</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="assets/css/Article-Clean.css">
    <link rel="stylesheet" href="assets/css/Footer-Clean.css">
    <link rel="stylesheet" href="assets/css/Header-Blue.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<?php 
$query = $dbh->query("SELECT *  FROM voorwerp");
while($row = $query->fetch()){
    $titel = $row['Titel'];
    $tijd = $row['Eindmoment'];
}

$query = $dbh->query("SELECT * from bestand where voorwerpnummer like 2");
while($row = $query->fetch()){
    $afbeelding = $row ['FileNaam'];
}

    ?>

<body style="background-color: #4b4c4d;">
    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="color: #a9976a;">Uitgelicht</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(assets/img/BMW-TA.jpg);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;"><?php echo $tijd ?></p>
                        <p class="text-left"  >
                        <?php echo $titel ?>
                    </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/<?php$afbeelding; ?>.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/Iphone_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/desk.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="color: #a9976a;">Looptijd bijna over</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/beach.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/beach.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="color: #a9976a;">Net binnen</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-between flex-wrap">
                <div class="col-md-3" style="width: 130px;margin: 15px;">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/B&D_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3" style="width: 130px;margin: 15px;">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/B&D_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3" style="width: 130px;margin: 15px;">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/B&D_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3" style="width: 130px;margin: 15px;">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/B&D_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3" style="width: 130px;margin: 15px;">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/B&D_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3" style="width: 130px;margin: 15px;">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/B&D_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3" style="width: 130px;margin: 15px;">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/B&D_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3" style="width: 130px;margin: 15px;">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/B&D_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
                <div class="col-md-3" style="width: 130px;margin: 15px;">
                    <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(&quot;assets/img/B&D_foto.jpg&quot;);">
                        <p class="d-flex align-items-start align-content-start align-self-start" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">05:00:00</p>
                        <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">Auto</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>


</html>


<?php
 include_once ("footer.php");?>