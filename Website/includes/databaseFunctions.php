<?php
function GetRubrieken($parent) {
    global $dbh;
    $mainCategoriesQuery = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Parent_Rubriek = ? AND Status='open' ORDER BY Volgnr, Rubrieknaam");
    $mainCategoriesQuery->execute([$parent]);
    $mainCategories = $mainCategoriesQuery->fetchAll();
    return $mainCategories;
}

function GetRubriekenPopulair($max) {
    global $dbh;
    $mainCategoriesQuery = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Parent_Rubriek = -1 AND Status='open' ORDER BY Volgnr, Rubrieknaam");
    $mainCategoriesQuery->execute();
    $mainCategories = $mainCategoriesQuery->fetchAll();
    return array_chunk($mainCategories, $max)[0];
}

function GetRubriekenFoto($id) {
    global $dbh;
    $fotoQuery = $dbh->prepare("SELECT RubriekFoto FROM RubriekFotos WHERE Rubrieknummer=?;");
    $fotoQuery->execute([$id]);
    $fotoPath = $fotoQuery->fetchAll();
    if (isset($fotoPath[0]) and isset($fotoPath[0][0])) {
        return "assets/img/Rubrieken/" . $fotoPath[0][0];
    } else {
        return null;
    }
}

function GetParentRubrieken($id) {
    global $dbh;
    $parentQuery = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer,Parent_Rubriek FROM Rubriek where Rubrieknummer = ? AND Status='open' ORDER BY Volgnr, Rubrieknaam");
    $parentQuery->execute([$id]);
    $parent = $parentQuery->fetch();
    return $parent;
}

function CountVoorwerpen() {
    global $dbh;
    $CountQuery = $dbh->prepare("SELECT count(voorwerpnummer) FROM Voorwerp");
    $CountQuery->execute();
    $Count = $CountQuery->fetch()[0];
    return $Count;
}

function GetVoorwerpEigenschappen($id) {
    global $dbh;
    $voorwerpQuery = $dbh->prepare("SELECT v.Titel, v.Beschrijving, v.Startprijs, v.Betalingswijze, g.Gebruikersnaam, v.Plaatsnaam, v.Land, v.Eindmoment, v.Verzendinstructies, v.Betalingsinstructie FROM Voorwerp v INNER JOIN Gebruiker g ON v.VerkopersID = g.GebruikersID WHERE Voorwerpnummer = ?");
    $voorwerpQuery->execute([$id]);
    return $voorwerpQuery->fetchAll();
}

function GetVoorwerpFoto($id) {
    global $dbh;
    $fotoQuery = $dbh->prepare("SELECT FileNaam FROM Bestand WHERE Voorwerpnummer= ?");
    $fotoQuery->execute([$id]);
    $fotoPath = $fotoQuery->fetchAll();
    return $fotoPath;
}

function GetBieders($id) {
    global $dbh;
    $biedersQuery = $dbh->prepare("SELECT b.BodBedrag, g.Gebruikersnaam, b.BodTijd FROM Bod b INNER JOIN Gebruiker g ON b.GebruikersID = g.GebruikersID WHERE Voorwerpnummer = ?");
    $biedersQuery->execute([$id]);
    $bieders = $biedersQuery->fetchAll();
    return $bieders;
}

function GetProductNaam($id) {
    global $dbh;
    $productnaamQuery = $dbh->prepare("SELECT Titel FROM Voorwerp WHERE Voorwerpnummer = ?");
    $productnaamQuery->execute([$id]);
    $productnaam = $productnaamQuery->fetch()[0];
    return $productnaam;
}

function GetMeerVanVerkoper($id) {
    global $dbh;
    $MeerVanVerkoperQuery = $dbh->prepare("SELECT TOP 4 v.Voorwerpnummer, b.FileNaam FROM Voorwerp v INNER JOIN Bestand b ON v.Voorwerpnummer = b.VoorwerpNummer INNER JOIN Verkoper ver ON v.VerkopersID = ver.GebruikersID WHERE V.VerkopersID IN 
                                          (SELECT VerkopersID FROM Voorwerp WHERE Voorwerpnummer = ?) ");
    $MeerVanVerkoperQuery->execute([$id]);
    $MeerVanVerkoper = $MeerVanVerkoperQuery->fetchAll();
    return $MeerVanVerkoper;
}

function GetVoorwerpen($id, $page = 0, $max = 40) {
    global $dbh;
    $all = GetAllSubRubrieken($id);
    $isIn = '( ' . implode(",", $all) . ' )';
    $query = "SELECT TOP " . $max . " v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies, b.FileNaam, vir.Rubrieknummer FROM Voorwerp v INNER JOIN Bestand b ON v.Voorwerpnummer = b.VoorwerpNummer INNER JOIN VoorwerpInRubriek vir ON v.Voorwerpnummer = vir.Voorwerpnummer WHERE v.VeilingGesloten = 0 AND vir.Rubrieknummer IN ";
    $query .= $isIn;
    $VoorwerpenQuery = $dbh->prepare($query);
    $VoorwerpenQuery->execute();
    $Voorwerpen = $VoorwerpenQuery->fetchAll();
    return $Voorwerpen;
}

function GetAllSubRubrieken($id) {
    $rubriekenID = [$id];
    foreach (GetRubrieken($id) as $key => $value) {
        $rubriekenID = array_merge($rubriekenID, GetAllSubRubrieken($value["Rubrieknummer"]));
    }
    return $rubriekenID;

}

?>