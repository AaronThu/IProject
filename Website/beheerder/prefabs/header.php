<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once "../includes/database.php";
include_once 'logica/databaseFuncties.php';

if (!isset($_SESSION['Gebruikersnaam']) || (isset($_SESSION['Gebruikersnaam']) && !IsAdmin($_SESSION['Gebruikersnaam']))) {
    header("Location: ../index.php");
    return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Beheerder</title>

    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button-1.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/Rubriek.css">
    <link rel="stylesheet" href="../assets/css/Breadcrum.css">
    <link rel="stylesheet" href="../assets/css/Subrubrieken.css">

</head>

<body>

    <nav class="navbar navbar-light navbar-expand-md sticky-top navigation-clean-button">

    </nav>