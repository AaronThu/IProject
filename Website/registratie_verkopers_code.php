<?php
session_start();
include_once "includes/database.php";
include_once "includes/functies.php";


$codeErr = "";
$locatieGoedeCode = "Location: index.php";

if(isset($_POST['verstuurCode'])){
    if(empty(test_invoer($_POST['RegistratieCode']))){
     $codeErr = "Vul de registratiecode in die is opgestuurd";
    } else {
        $waardes = vergelijkVerkopersRegistratieCode($_SESSION['GebruikersID'], test_invoer($_POST['RegistratieCode']), $dbh);
        if (empty($waardes)) {
            $codeErr = 'U heeft zich nog niet geregistreerd voor verkoper, klik <a href="registreren_verkoper.php">hier</a> om te registreren';
        } elseif ($waardes[2] == 1) {
            $codeErr = "Deze code is niet meer geldig, laat een nieuwe code naar je sturen";
        } elseif ($waardes[1] == test_invoer($_POST['RegistratieCode'])) {
            print $_SESSION['GebruikersID'];
            //updateSoortGebruikerStatus($dbh, "verkoper", $_SESSION['GebruikersID']);
            updateVerkoperStatus($dbh, $_SESSION['GebruikersID']);
            $_SESSION['foutmelding'] = "U bent geregistreerd als verkoper, u kunt nu een voorwerp aanbieden";
            $_SESSION['VerkoperStatus'] = "geactiveerd";
            header($locatieGoedeCode);
            return;
        } else {
            $codeErr = "Dit is niet de juiste code, probeer het opnieuw";
        }
    }
}

include_once "includes/header.php";
?>


<div class="container" style="margin-bottom: 10em;">
    <div class="row">
        <div class=" col-md-12">
            <h2 class="text-center" style="color: rgb(255,255,255);">Registratiecode voor verkoper</h2>
            <p class = "text-center" style="color: rgb(255,255,255);margin-bottom:50px;"> Door te registreren als verkoper accepteert u onze <a href="algemene_voorwaarden.php"> algemene voorwaarden.</a></p>
        </div>
    </div>

    <form style="color: white" method="post" action="registratie_verkopers_code.php">
    <div class="registratiepagina" style="margin: 2em 20%;">
    <h6 style="text-align: center;">Vul de code in die is opgestuurd</h6>
    <h6 class="text-left foutmeldingTekst"> <?php echo $codeErr ?> </h6>
        <div class="form-group"><input class="form-control inputforms" type="number" name="RegistratieCode" placeholder="RegistratieCode" value=''></div>
    </div>


    <div class ="registratiebutton">
        <button class="btn btn-primary text-center Registratieknop" style="background-color: #a9976a; color: white" type="submit" name="verstuurCode">Registreren als verkoper</button>
    </div>
    </form>
</div>
</body>

<?php
include_once "includes/footer.php";
?>