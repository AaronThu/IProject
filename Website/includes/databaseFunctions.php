<?php

//returned rubrieken met meegegeven parent rubriek
function GetRubrieken($parent)
{
    global $dbh;
    $mainCategoriesQuery = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Parent_Rubriek = ? AND Status='open' ORDER BY Volgnr, Rubrieknaam");
    $mainCategoriesQuery->execute([$parent]);
    $mainCategories = $mainCategoriesQuery->fetchAll();
    return $mainCategories;
}

// returned meegegeven aantal rubrieken
function GetRubriekenPopulair($max)
{
    global $dbh;
    $mainCategoriesQuery = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Parent_Rubriek = -1 AND Status='open' ORDER BY Volgnr, Rubrieknaam");
    $mainCategoriesQuery->execute();
    $mainCategories = $mainCategoriesQuery->fetchAll();
    return array_chunk($mainCategories, $max)[0];
}

// returned rubriek foto van meegegeven rubriek id. returned null als er geen foto is.
function GetRubriekenFoto($id)
{
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

// returned parent rubriek van meegegeven rubriek id
function GetParentRubrieken($id)
{
    global $dbh;
    $parentQuery = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer,Parent_Rubriek FROM Rubriek where Rubrieknummer = ? AND Status='open' ORDER BY Volgnr, Rubrieknaam");
    $parentQuery->execute([$id]);
    $parent = $parentQuery->fetch();
    return $parent;
}

//returned totaal aantal voorwerpen.
function CountVoorwerpen()
{
    global $dbh;
    $CountQuery = $dbh->prepare("SELECT count(voorwerpnummer) FROM Voorwerp");
    $CountQuery->execute();
    $Count = $CountQuery->fetch()[0];
    return $Count;
}

//returned voorwerp eigenschappen( titel, beschrijving, startprijs, betaalwijzen, gebruikersnaam, plaatsnaam, land, einmoment, verzending, verzendinstrucies, betaalinstructies, verkoper.
function GetVoorwerpEigenschappen($id)
{
    global $dbh;
    $voorwerpQuery = $dbh->prepare("SELECT v.Titel, v.Beschrijving, v.Startprijs, v.Betalingswijze, g.Gebruikersnaam, v.Plaatsnaam, v.Land, v.Eindmoment, v.Verzendinstructies, v.Betalingsinstructie, v.VerkopersID FROM Voorwerp v INNER JOIN Gebruiker g ON v.VerkopersID = g.GebruikersID WHERE Voorwerpnummer = ?");
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
    $biedersQuery = $dbh->prepare("SELECT TOP 3 b.BodBedrag, g.Gebruikersnaam, b.BodTijd FROM Bod b INNER JOIN Gebruiker g ON b.GebruikersID = g.GebruikersID WHERE Voorwerpnummer = ? ORDER BY BodTijd DESC");
    $biedersQuery->execute([$id]);
    $bieders = $biedersQuery->fetchAll();
    return $bieders;
}

function GetProductNaam($id)
{
    global $dbh;
    $productnaamQuery = $dbh->prepare("SELECT Titel FROM Voorwerp WHERE Voorwerpnummer = ?");
    $productnaamQuery->execute([$id]);
    $productnaam = $productnaamQuery->fetch()[0];
    return $productnaam;
}

function GetMeerVanVerkoper($id)
{
    global $dbh;
    $voorwerpnummer = $id;
    $MeerVanVerkoperQuery = $dbh->prepare("SELECT DISTINCT TOP 4 v.Voorwerpnummer, b.FileNaam FROM Voorwerp v INNER JOIN Bestand b ON v.Voorwerpnummer = b.VoorwerpNummer INNER JOIN Verkoper ver ON v.VerkopersID = ver.GebruikersID WHERE v.Voorwerpnummer != $voorwerpnummer and VerkopersID IN
                                          (SELECT VerkopersID FROM Voorwerp WHERE Voorwerpnummer = $voorwerpnummer)");
    $MeerVanVerkoperQuery->execute([$id]);
    $MeerVanVerkoper = $MeerVanVerkoperQuery->fetchAll();
    return $MeerVanVerkoper;
}

function GetVoorwerpen($id, $orderOn = [], $aflopen = false, $page = 1, $max = 10)
{
    global $dbh;
    $all = GetAllSubRubrieken($id);
    $lowerLimit = ($page - 1) * $max;
    $upperLimit = ($page * $max) - 1;
    $orderBy = "";
    foreach ($orderOn as $key => $value) {
        if ($key === 0) {
            $orderBy = "ORDER BY " . $value;
        } else {
            $orderBy .= ", " . $value;
        }
    }
    if ($orderBy === "") {
        $orderBy = "ORDER BY v.Voorwerpnummer";
    }
    if ($aflopen) {
        $orderBy .= " DESC";
    }
    $query = "WITH VoorwerpenPagina AS (SELECT ROW_NUMBER() OVER( $orderBy ) as ROWNumber , v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies, (SELECT TOP 1 b.FileNaam FROM Bestand b WHERE b.VoorwerpNummer = v.Voorwerpnummer) as FileNaam, vir.Rubrieknummer FROM Voorwerp v INNER JOIN VoorwerpInRubriek vir ON v.Voorwerpnummer = vir.Voorwerpnummer WHERE  Veilinggesloten = 0 AND Rubrieknummer IN ( " . implode(",", $all) . " )) SELECT * from VoorwerpenPagina WHERE ROWNumber BETWEEN ? AND ? ";
    $VoorwerpenQuery = $dbh->prepare($query);
    $VoorwerpenQuery->execute([$lowerLimit, $upperLimit]);
    $Voorwerpen = $VoorwerpenQuery->fetchAll();
    return $Voorwerpen;
}

function GetVoorwerpCount($id)
{
    global $dbh;
    $all = GetAllSubRubrieken($id);
    $query = "SELECT COUNT (v.Voorwerpnummer) FROM Voorwerp v INNER JOIN VoorwerpInRubriek vir ON v.Voorwerpnummer = vir.Voorwerpnummer
	WHERE Rubrieknummer IN ( " . implode(",", $all) . " ) AND v.Veilinggesloten = 0";
    $CountQuery = $dbh->prepare($query);
    $CountQuery->execute();
    $Count = $CountQuery->fetch();
    return $Count[0];
}

function GetAllSubRubrieken($id)
{
    $rubriekenID = [$id];
    foreach (GetRubrieken($id) as $key => $value) {
        $rubriekenID = array_merge($rubriekenID, GetAllSubRubrieken($value["Rubrieknummer"]));
    }
    return $rubriekenID;
}

function GetVoorwerpenSearchBar($id)
{
    global $dbh;
    $query = "SELECT v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies, b.FileNaam FROM Voorwerp v INNER JOIN Bestand b ON v.Voorwerpnummer = b.VoorwerpNummer WHERE v.VeilingGesloten = 0 and titel like '%" . $id . "%'";
    $SearchQuery = $dbh->prepare($query);
    $SearchQuery->execute();
    $Searching = $SearchQuery->fetchAll();
    return $Searching;
}

function GetHoogsteBod($id)
{
    global $dbh;
    $HoogsteBodQuery = $dbh->prepare("SELECT TOP 1 Bodbedrag, GebruikersID FROM Bod WHERE VoorwerpNummer = ? ORDER BY Bodbedrag DESC");
    $HoogsteBodQuery->execute([$id]);
    $HoogsteBod = $HoogsteBodQuery->fetchAll();
    return $HoogsteBod;
}

function GetFeedbackVoorVerkoper($dbh, $gebruikersID)
{
    $query = $dbh->prepare("SELECT AVG(FeedbackNummer) FROM Feedback WHERE VerkopersID = :VerkopersID");
    $query->execute([':VerkopersID' => $gebruikersID]);
    $waarde = $query->fetch();
    return $waarde[0];
}

function GetBiedingen($userID, $type = 'all')
{
    global $dbh;
    $Query = null;
    switch ($type) {
        case 'old':
            $Query = $dbh->prepare("SELECT v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies FROM Voorwerp v WHERE v.Voorwerpnummer IN (SELECT b.Voorwerpnummer FROM Bod b WHERE b.GebruikersID = ?) AND Veilinggesloten = 1 ORDER BY v.Eindmoment");
            break;
        case 'new':
            $Query = $dbh->prepare("SELECT v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies FROM Voorwerp v WHERE v.Voorwerpnummer IN (SELECT b.Voorwerpnummer FROM Bod b WHERE b.GebruikersID = ?) AND Veilinggesloten = 0 ORDER BY v.Eindmoment");
            break;
        default:
            $Query = $dbh->prepare("SELECT v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies FROM Voorwerp v WHERE v.Voorwerpnummer IN (SELECT b.Voorwerpnummer FROM Bod b WHERE b.GebruikersID = ?) ORDER BY v.Eindmoment");
            break;
    }
    $Query->execute([$userID]);
    return $Query->fetchAll();
}

function GetNotificaties($gebruikersID, $SoortGebruiker)
{
    global $dbh;
    GetBiedingGeslotenNotificaties($gebruikersID, $SoortGebruiker);
    $query = $dbh->prepare("SELECT * FROM GebruikerNotificaties WHERE GebruikersID = :GebruikersID");
    $query->execute([':GebruikersID' => $gebruikersID]);
    $gegevens = $query->fetchAll();
    return $gegevens;
}

function GetBiedingGeslotenNotificaties($GebruikersID, $SoortGebruiker)
{
    $GeslotenVoorwerpen = KijkVoorBiedingVoorbij($GebruikersID, $SoortGebruiker);
    if (!empty($GeslotenVoorwerpen)) {
        for ($i = 0; $i < count($GeslotenVoorwerpen); $i++) {
            if ($SoortGebruiker == 'Verkoper' && KijkVoorOudeNotificaties($GeslotenVoorwerpen[$i]['Voorwerpnummer'], $GebruikersID, 'voorwerpVerkocht') == 0) {
                VoegNotificatieToe($GebruikersID, $GeslotenVoorwerpen[$i]['Voorwerpnummer'], 'voorwerpVerkocht');
            } elseif ($SoortGebruiker == 'Koper' && KijkVoorOudeNotificaties($GeslotenVoorwerpen[$i]['Voorwerpnummer'], $GebruikersID, 'voorwerpGekocht') == 0) {
                VoegNotificatieToe($GebruikersID, $GeslotenVoorwerpen[$i]['Voorwerpnummer'], 'voorwerpGekocht');
            }
        }
    }
}

function VoegNotificatieToe($gebruikersID, $VoorwerpNummer, $NotificatieSoort)
{
    global $dbh;
    $query = $dbh->prepare("INSERT INTO GebruikerNotificaties(GebruikersID, Voorwerpnummer, NotificatieSoort) VALUES(:GebruikersID, :VoorwerpNummer, :NotificatieSoort)");
    $query->execute([
        ':GebruikersID' => $gebruikersID,
        ':VoorwerpNummer' => $VoorwerpNummer,
        ':NotificatieSoort' => $NotificatieSoort
    ]);
}

function VerwijderNotificaties($GebruikersID)
{
    global $dbh;
    $query = $dbh->prepare("UPDATE GebruikerNotificaties SET NotificatieGelezen = 1 WHERE GebruikersID = :GebruikersID");
    $query->execute([':GebruikersID' => $GebruikersID]);
}

function GetVoorwerpenVoorVerkoper($VerkopersID)
{
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM Voorwerp WHERE VerkopersID = :VerkopersID");
    $query->execute([':VerkopersID' => $VerkopersID]);
    return $query->fetchAll();
}

function KijkVoorBiedingVoorbij($ID, $SoortGebruiker)
{
    global $dbh;
    if ($SoortGebruiker == 'Verkoper') {
        $soort = "VerkopersID";
    } else {
        $soort = "KopersID";
    }
    $query = $dbh->prepare("SELECT Voorwerpnummer, KopersID FROM VOORWERP WHERE $soort = :ID AND VeilingGesloten = 0");
    $query->execute([':ID' => $ID]);
    $waardes = $query->fetchAll();
    return $waardes;
}

function KijkVoorOudeNotificaties($Voorwerpnummer, $GebruikerID, $NotificatieSoort)
{
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM GebruikerNotificaties WHERE NotificatieGelezen = 1 AND Voorwerpnummer = :Voorwerpnummer AND GebruikersID = :GebruikersID");
    $query->execute([
        ':Voorwerpnummer' => $Voorwerpnummer,
        ':GebruikersID' => $GebruikerID
    ]);
    return $query->rowcount();
}

function UpdateVoorwerpKopersID($GebruikersID, $Voorwerpnummer)
{
    global $dbh;
    $query = $dbh->prepare("UPDATE Voorwerp SET KopersID = :GebruikersID WHERE Voorwerpnummer = :Voorwerpnummer");
    $query->execute([
        ':GebruikersID' => $GebruikersID,
        ':Voorwerpnummer' => $Voorwerpnummer
    ]);
}
