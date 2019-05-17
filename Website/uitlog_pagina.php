<?php
session_destroy();
session_start();
$_SESSION['Gebruikersnaam'] = "";
$_SESSION['foutmelding'] = "U bent uitgelogd";
header("Location: index.php");