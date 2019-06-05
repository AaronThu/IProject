<?php
include_once("includes/header.php");
$zoekterm = $_GET['zoekterm'];
?>

<?php foreach (GetVoorwerpenSearchBar($zoekterm) as $key => $value) {?>
    <div class="container">
        <div class="container voorwerp">
            <div class="row">
                <div class="col-md-4">
                    <a href="voorwerppagina.php?voorwerpID=<?php echo $value['Voorwerpnummer']; ?>"><img style="background-image: url(&quot;http://iproject2.icasites.nl/pics/<?php echo $value['FileNaam']; ?>&quot;);width: 250px;height: 166px; background-size: cover; margin-left: -0.5em; margin-top: 0.5em;"></a>

                </div>
                <div class="col-md-5">
                    <p><?php echo $value['Titel']; ?></p>
                </div>
                <div class="col-md-3">
                    <h3 style="color: #ffffff;width: 111px;"><?php echo "€" . $value['Startprijs']; ?>&nbsp;</h3><br><br>
                    <img class = 'clock'src = "assets/img/clock.jpg"><h6 class="Timer" data-time="<?php echo ($value['Eindmoment']); ?>" style="display: inline; color: #ffffff"></h6><br><br><br><br>
                    <a class="btn btn-light d-xl-flex justify-content-end align-items-end align-content-end align-self-end flex-wrap mr-auto justify-content-xl-center align-items-xl-center" role="button" style="background-color: #a9976a;padding: 5px;height: auto;width: Auto;margin: 0px;color: #ffffff;" href="voorwerppagina.php?voorwerpID=<?php echo $value['Voorwerpnummer']; ?>">Bied nu mee!</a>
                </div>
            </div>
        </div>
  </div>
  
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/timer.js"></script>
<script src="assets/js/pagenation.js"></script>
<?php
  }
include_once ("includes/footer.php");?>
