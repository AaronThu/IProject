<?php
session_start();
include_once('database.php');
include_once('functies.php');

$emailErr = "";
$tijdLinkGeldig = 14400;

if(isset($_POST['verstuurmail'])){
    $_SESSION['Emailadres'] = test_invoer($_POST['Emailadres']);
    $tellingemailadres = vergelijkloginwaarde("Emailadres", $_SESSION['Emailadres'], $dbh);

    if(empty($_POST['Emailadres'])){
        $emailErr = "Email is verplicht";
    } elseif($tellingemailadres){
        $emailErr = "Dit email-adres is al in gebruik";
    } elseif(filter_var($_SESSION['Emailadres'], FILTER_VALIDATE_EMAIL) == false){
        $emailErr = "Vul een correct geformuleerd email-adres in";
    } else{
        header("Location: http://localhost/inlogServer/mail.php");
    }
}

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    $masterPW = "test";
    $meegevenHash = $_GET['hash'];
    $email = $_GET['email'];
    $gegevenTijd = $_GET['tijd'];
    $hash = hash('md5', $email . $masterPW);
    if($hash == $meegevenHash && time() - $gegevenTijd < $tijdLinkGeldig){
        $_SESSION['Emailadres'] = $email;
        header("Location: http://localhost/inlogServer/registratiesysteem.php");
    } elseif(time() - $gegevenTijd > $tijdLinkGeldig){
        $_SESSION['foutmelding'] = "Deze link is niet meer geldig, laat een nieuwe mail naar je versturen";
        }else{
        $_SESSION['foutmelding'] = "De opgegeven link is invalide, gebruik de link die is opgestuurd";
    }
} else{
    $_SESSION['foutmelding'] = "Dit is geen valide adres, gebruik de link die is opgestuurd";
}

?>

<form method="post" class="formulier" action="emailpagina.php">
<label for="Emailadres"> </label><br>
    <input type="email" name="Emailadres" maxlength="255" placeholder="E-mailadres" >* <?php echo $emailErr;?>
    <input type="submit" name="verstuurmail" Value="Verstuur email">
</form>