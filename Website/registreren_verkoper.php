<?php
session_start();
include_once "includes/database.php";
include_once "includes/functies.php";
include_once "includes/header.php";

$locatieFouteLink = "Location: registreren_emailpagina.php";
/*
if (empty($_SESSION['Emailadres'])) {
    $_SESSION['foutmelding'] = "Je moet eerst registreren als gebruiker voordat je mag registreren als verkoper";
    header($locatieFouteLink);
    return;
}*/

$_SESSION['rekeningnummerErr'] = "";
$_SESSION['rekeningHouderErr'] = "";

if(isset($_POST['verkoperRegistreren'])){
if(empty(test_invoer($_POST['rekeningnummer'])) || strlen((test_invoer($_POST['rekeningnummer']))) <= 5){
    $_SESSION['rekeningnummerErr'] = "dit rekeningnummer is niet geldig";
} else {
    $_SESSION['rekeningNummer'] = test_invoer($_POST['rekeningnummer']);
}

if(empty(test_invoer($_POST['naamVanGebruiker']))){
    $_SESSION['rekeningHouderErr'] = "Vul alstublieft de naam in die bekend is bij uw bank";
} else {
    $_SESSION['rekeningHouder'] = test_invoer($_POST['naamVanGebruiker']);
}

if(empty($_SESSION['rekeningHouderErr']) || empty($_SESSION['rekeningnummerErr'])){

}
}


$_SESSION['Voornaam'] = "Josse";
$_SESSION['Achternaam'] = "Nobel";





$rekeninnummerErr = "";
$nameVanErr = "";
?>

<html>


<body>
    <div class="container" style="margin-bottom: 10em;">
        <div class="row">
                <div class=" col-md-12">
        <h2 class="text-center" style="color: rgb(255,255,255);">Registreren als verkoper</h2>
        <p class = "text-center"style="color: rgb(255,255,255);margin-bottom:50px;"> Door te registreren als verkoper accepteert u onze <a href="algemene_voorwaarden.php"> algemene voorwaarden.</p></a>
    </div>
        </div>



<div style=" margin: 50px 15em;">
    <form style="color: white" method="post" action="registreren_verkoper.php">

        <h6 style="text-align: center;">Soort rekeningnummer</h1>
        <input type="radio" name="soortRekening" value="CreditcardNummer" >Creditcard nummer<br>
        <input type="radio" name="soortRekening" value="IBANNummer" style="margin-bottom: 2em;">IBAN nummer<br>

        <h6 style="text-align: center;">Kies een optie waarmee wij jouw gegevens kunnen controleren</h6>
        <input type="radio" name="controleOptie" value="Post" >Stuur een brief met code naar mijn adres<br>
        <input type="radio" name="controleOptie" value="Creditcard" style="margin-bottom: 2em;">Via jouw creditcard gegevens<br>
<div class="registratiepagina" style="margin-bottom: 2em;">

    <select class="form-control inputforms" name="Bank">
        <option>Selecteer bank</option>
        <?php
        foreach (GeefBankenLijst($dbh) as $key => $value) {
            if($value[Bank] == $_POST["Bank"]){
                print("<option selected>$value[Bank]</option>");
            }else {
                print("<option> $value[Bank]</option>");
            }
        }?>
    </select>
    <h6 style="text-align: center;">Rekeningnummer</h6>
    <h6 class="text-left foutmeldingTekst"> <?php echo $_SESSION['rekeningnummerErr'] ?> </h6>
    <div class="form-group"><input class="form-control inputforms" type="text" name="rekeningnummer" placeholder="Rekeningnummer" value="<?php echo isset($_POST["rekeningnummer"]) ? $_POST["rekeningnummer"] : '';?>"></div>

    <h6 style="text-align: center;">De volledige naam die bekend is bij de bank</h6>
    <h6 class="text-left foutmeldingTekst"> <?php echo $_SESSION['rekeningHouderErr'] ?> </h6>
    <div class="form-group"><input class="form-control inputforms" type="text" name="naamVanGebruiker" placeholder="" value="<?php echo isset($_POST["naamVanGebruiker"]) ? $_POST["naamVanGebruiker"] : $_SESSION['Voornaam'] . " " . $_SESSION["Achternaam"]; ?>" ></div>

</div>
            <div class ="registratiebutton">
                <button class="btn btn-primary text-center Registratieknop" style="background-color: #a9976a;" type="submit" name="verkoperRegistreren">Registreren als verkoper</button>
            </div>

    </form>
</div>


</div>

</body>
</html>

<?php
include_once "includes/footer.php";
?>


