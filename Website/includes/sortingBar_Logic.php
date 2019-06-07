<?php
$sortOn = [];
$aflopen = false;
if (isset($_GET["SortNaam"]) && $_GET["SortNaam"] === "on") {
    array_push($sortOn, "Titel");
}
if (isset($_GET["SortPrijs"]) && $_GET["SortPrijs"] === "on") {
    array_push($sortOn, "Verkoopprijs, Startprijs");
}
if (isset($_GET["SortTijdResterend"]) && $_GET["SortTijdResterend"] === "on") {
    array_push($sortOn, "Eindmoment");
}
if (isset($_GET["SortAflopend"]) && $_GET["SortAflopend"] === "on") {
    $aflopen = true;
}
