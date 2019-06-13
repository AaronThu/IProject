<?php
session_start();
include_once "includes/database.php";
include_once "includes/functies.php";

$locatieFouteLink = "Location: registreren_emailpagina.php";
$locatieRegistratie = "Location: registreren_verkopersysteem.php";

if (empty($_SESSION['Emailadres'])) {
    $_SESSION['foutmelding'] = "Je moet eerst registreren/inloggen als gebruiker voordat je mag registreren als verkoper.";
    header($locatieFouteLink);
    return;
}

$_SESSION['rekeningnummerErr'] = "";
$_SESSION['rekeningHouderErr'] = "";
$_SESSION['bankErr'] = "";
$_SESSION['datumErr'] = "";

// Controlleerd of de gebruiker de juiste gegevens heeft ingevuld
if(isset($_POST['verkoperRegistreren'])) {
    if (empty(test_invoer($_POST['rekeningnummer'])) || strlen((test_invoer($_POST['rekeningnummer']))) <= 5) {
        $_SESSION['rekeningnummerErr'] = "dit rekeningnummer is niet geldig";
    } else {
        $_SESSION['Rekeningnummer'] = test_invoer($_POST['rekeningnummer']);
    }

    if (empty(test_invoer($_POST['naamVanGebruiker']))) {
        $_SESSION['rekeningHouderErr'] = "Vul alstublieft de naam in die bekend is bij uw bank";
    } else {
        $_SESSION['rekeningHouder'] = test_invoer($_POST['naamVanGebruiker']);
    }

    if (test_invoer($_POST['Bank']) == 'Selecteer bank') {
        $_SESSION['bankErr'] = "U moet een bank selecteren";
    } else {
        $_SESSION['Bank'] = test_invoer($_POST['Bank']);
    }

    $huidigeTijd = time();
    $datumPas = strtotime($_POST['EinddatumPas']);

    if (empty(test_invoer($_POST['EinddatumPas']))) {
        $_SESSION['datumErr'] = "Geef de einddatum van je pas op";
    } elseif ($datumPas < $huidigeTijd) {
        $_SESSION['datumErr'] = "De datum moet in de toekomst liggen";
    } else {
        $_SESSION['einddatum'] = date("m-d-Y", strtotime($_POST['EinddatumPas']));
    }


    if (empty($_SESSION['rekeningHouderErr']) && empty($_SESSION['rekeningnummerErr']) && empty($_SESSION['bankErr']) && empty($_SESSION['datumErr'])) {
        $_SESSION['controleOptie'] = $_POST['controleOptie'];
        $_SESSION['SoortRekening'] = $_POST['soortRekening'];
        header($locatieRegistratie);
        return;
    }
}

include_once "includes/header.php";
?>

<!-- Formulier om gegevens in te vullen -->
<div class="background">
    <div class="container" style="margin-bottom: 10em;">
        <div class="row">
            <div class=" col-md-12">
            <h2 class="text-center" style="color: rgb(255,255,255);">Registreren als verkoper</h2>
            <p class = "text-center" style="color: rgb(255,255,255);margin-bottom:50px;"> Door te registreren als verkoper accepteert u onze <a href="algemene_voorwaarden.php" target="_blank"> algemene voorwaarden.</a></p>
        </div>
    </div>
<div style=" margin: 50px 15em;">
    <form style="color: white" method="post" action="registreren_verkoper.php">
        <h6 style="text-align: center;">Soort rekeningnummer</h6>
        <input type="radio" name="soortRekening" value="creditcard" >Creditcard nummer<br>
        <input type="radio" name="soortRekening" value="pinpas" style="margin-bottom: 2em;" checked>IBAN nummer<br>

        <h6 style="text-align: center;">Kies een optie waarmee wij jouw gegevens kunnen controleren</h6>
        <input type="radio" name="controleOptie" value="Post" checked>Stuur een brief met code naar mijn adres<br>
        <input type="radio" name="controleOptie" value="Creditcard" style="margin-bottom: 2em;">Via jouw creditcard gegevens<br>
<div class="registratiepagina" style="margin-bottom: 2em;">

    <h6 class="text-left foutmeldingTekst"> <?php echo $_SESSION['bankErr'] ?> </h6>
    <select class="form-control inputforms" name="Bank">
        <option>Selecteer bank</option>
        <?php
        foreach (GeefBankenLijst($dbh) as $key => $value) {
            if($value["Bank"] == $_POST["Bank"]){
                print("<option selected>$value[Bank]</option>");
            }else {
                print("<option> $value[Bank]</option>");
            }
        }?>
    </select>
    <h6 style="text-align: center;">Rekeningnummer</h6>
    <h6 class="text-left foutmeldingTekst"> <?php echo $_SESSION['rekeningnummerErr'] ?> </h6>
    <div class="form-group"><input class="form-control inputforms" type="text" name="rekeningnummer" placeholder="Rekeningnummer" value="<?php echo isset($_POST["rekeningnummer"]) ? $_POST["rekeningnummer"] : '';?>" maxlength="20"></div>

    <h6 style="text-align: center;">De volledige naam die bekend is bij de bank</h6>
    <h6 class="text-left foutmeldingTekst"> <?php echo $_SESSION['rekeningHouderErr'] ?> </h6>
    <div class="form-group"><input class="form-control inputforms" type="text" name="naamVanGebruiker" placeholder="" value="<?php echo isset($_POST["naamVanGebruiker"]) ? $_POST["naamVanGebruiker"] : $_SESSION['Voornaam'] . " " . $_SESSION["Achternaam"]; ?>" maxlength="20"></div>

    <h6 style="text-align: center;">De einddatum van jouw pas</h6>
    <h6 class="text-left foutmeldingTekst"> <?php echo $_SESSION['datumErr'] ?> </h6>
    <div class="form-group"><input class="form-control inputforms" type="date" name="EinddatumPas" value="<?php echo isset($_POST["EinddatumPas"]) ? $_POST["EinddatumPas"] : '' ?>"></div>
</div>
    <div class ="registratiebutton">
    <button class="btn btn-primary text-center Registratieknop" style="background-color: #a9976a; color: white" type="submit" name="verkoperRegistreren">Registreren als verkoper</button>
    </div>
    </form>
</div>
</div>
</div>
</body>
<?php
include_once "includes/footer.php";
?>