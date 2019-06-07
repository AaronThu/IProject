<?php
function MinimaleBiedPrijs($HoogsteBod)
{
    $MinimaalTeBieden = 0;
    if ($HoogsteBod <= 49.99) {
        $MinimaalTeBieden = 0.50;
    } elseif ($HoogsteBod <= 499.99) {
        $MinimaalTeBieden = 1.00;
    } elseif ($HoogsteBod <= 999.99) {
        $MinimaalTeBieden = 5.00;
    } elseif ($HoogsteBod <= 4999.99) {
        $MinimaalTeBieden = 10.00;
    } elseif ($HoogsteBod >= 5000.00) {
        $MinimaalTeBieden = 50.00;
    }
    return $MinimaalTeBieden;
}
//returned voorwerp eigenschappen( titel, beschrijving, startprijs, betaalwijzen, gebruikersnaam, plaatsnaam, land, einmoment, verzending, verzendinstrucies, betaalinstructies, verkoper.
function GetVoorwerpEigenschappen($id)
{
    global $dbh;
    $voorwerpQuery = $dbh->prepare("SELECT v.Titel, v.Beschrijving, v.Startprijs, v.Betalingswijze, g.Gebruikersnaam, v.Plaatsnaam, v.Land, v.Eindmoment, v.Verzendinstructies, v.Betalingsinstructie, v.VerkopersID, v.Verkoopprijs, v.KopersID FROM Voorwerp v INNER JOIN Gebruiker g ON v.VerkopersID = g.GebruikersID WHERE Voorwerpnummer = ?");
    $voorwerpQuery->execute([$id]);
    return $voorwerpQuery->fetchAll();
}

//returned voorwerp foto path van meegegeven voorwerp id.
function GetVoorwerpFoto($id)
{
    global $dbh;
    $fotoQuery = $dbh->prepare("SELECT FileNaam FROM Bestand WHERE Voorwerpnummer= ?");
    $fotoQuery->execute([$id]);
    $fotoPath = $fotoQuery->fetchAll();
    return $fotoPath;
}

//returned bieders van meegegeven voorwerp id
function GetBieders($id)
{
    global $dbh;
    $biedersQuery = $dbh->prepare("SELECT TOP 3 b.BodBedrag, g.Gebruikersnaam, b.BodTijd, b.GebruikersID FROM Bod b INNER JOIN Gebruiker g ON b.GebruikersID = g.GebruikersID WHERE Voorwerpnummer = ? ORDER BY BodTijd DESC");
    $biedersQuery->execute([$id]);
    $bieders = $biedersQuery->fetchAll();
    return $bieders;
}

//returnt title van meegegeven voorwerp id.
function GetProductNaam($id)
{
    global $dbh;
    $productnaamQuery = $dbh->prepare("SELECT Titel FROM Voorwerp WHERE Voorwerpnummer = ?");
    $productnaamQuery->execute([$id]);
    $productnaam = $productnaamQuery->fetch()[0];
    return $productnaam;
}
//returned meer items van meegegeven verkoper
function GetMeerVanVerkoper($id, $limit = true)
{
    global $dbh;
    $voorwerpnummer = $id;
    if ($limit) {
        $MeerVanVerkoperQuery = $dbh->prepare("SELECT DISTINCT TOP 4 v.Voorwerpnummer, b.FileNaam FROM Voorwerp v INNER JOIN Bestand b ON v.Voorwerpnummer = b.VoorwerpNummer INNER JOIN Verkoper ver ON v.VerkopersID = ver.GebruikersID WHERE v.Voorwerpnummer != $voorwerpnummer and VerkopersID IN
                                          (SELECT VerkopersID FROM Voorwerp WHERE Voorwerpnummer = $voorwerpnummer)");
    } else {
        $MeerVanVerkoperQuery = $dbh->prepare("SELECT DISTINCT  v.Voorwerpnummer, b.FileNaam FROM Voorwerp v INNER JOIN Bestand b ON v.Voorwerpnummer = b.VoorwerpNummer INNER JOIN Verkoper ver ON v.VerkopersID = ver.GebruikersID WHERE v.Voorwerpnummer != $voorwerpnummer and VerkopersID IN
                                          (SELECT VerkopersID FROM Voorwerp WHERE Voorwerpnummer = $voorwerpnummer)");
    }
    $MeerVanVerkoperQuery->execute([$id]);
    $MeerVanVerkoper = $MeerVanVerkoperQuery->fetchAll();
    return $MeerVanVerkoper;
}
function GetBiedingen($userID, $type = 'all')
{
    global $dbh;
    $Query = null;
    switch ($type) {
        case 'old':
            $Query = $dbh->prepare("SELECT v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Verkoopprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies FROM Voorwerp v WHERE v.Voorwerpnummer IN (SELECT b.Voorwerpnummer FROM Bod b WHERE b.GebruikersID = ?) AND Veilinggesloten = 1 ORDER BY v.Eindmoment");
            break;
        case 'new':
            $Query = $dbh->prepare("SELECT v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Verkoopprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies FROM Voorwerp v WHERE v.Voorwerpnummer IN (SELECT b.Voorwerpnummer FROM Bod b WHERE b.GebruikersID = ?) AND Veilinggesloten = 0 ORDER BY v.Eindmoment");
            break;
        default:
            $Query = $dbh->prepare("SELECT v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Verkoopprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies FROM Voorwerp v WHERE v.Voorwerpnummer IN (SELECT b.Voorwerpnummer FROM Bod b WHERE b.GebruikersID = ?) ORDER BY v.Eindmoment");
            break;
    }
    $Query->execute([$userID]);
    return $Query->fetchAll();
}
function GetFeedbackVoorVerkoper($dbh, $gebruikersID)
{
    $query = $dbh->prepare("SELECT AVG(FeedbackNummer) FROM Feedback WHERE VerkopersID = :VerkopersID");
    $query->execute([':VerkopersID' => $gebruikersID]);
    $waarde = $query->fetch();
    return $waarde[0];
}