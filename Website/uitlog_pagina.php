<!-- Logt de gebuiker uit -->
<?php
session_start();
session_destroy();
session_start();
$_SESSION['Gebruikersnaam'] = "";
$_SESSION['foutmelding'] = "U bent uitgelogd";
header("Location: index.php");
?>