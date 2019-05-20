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
</head>

<body>

</body>

</html>