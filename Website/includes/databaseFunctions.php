<?php
function GetRubrieken($parent)
{
    global $dbh;
    $mainCategoriesQuery = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Parent_Rubriek = ? AND Status='open' ORDER BY Volgnr, Rubrieknaam");
    $mainCategoriesQuery->execute([$parent]);
    $mainCategories = $mainCategoriesQuery->fetchAll();
    return $mainCategories;
}

function GetRubriekenPopulair($max)
{
    global $dbh;
    $mainCategoriesQuery = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Parent_Rubriek = -1 AND Status='open' ORDER BY Volgnr, Rubrieknaam");
    $mainCategoriesQuery->execute();
    $mainCategories = $mainCategoriesQuery->fetchAll();
    return array_chunk($mainCategories, $max)[0];
}

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

function GetParentRubrieken($id)
{
    global $dbh;
    $parentQuery = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer,Parent_Rubriek FROM Rubriek where Rubrieknummer = ? AND Status='open' ORDER BY Volgnr, Rubrieknaam");
    $parentQuery->execute([$id]);
    $parent = $parentQuery->fetch();
    return $parent;
}

function CountVoorwerpen()
{
    global $dbh;
    $CountQuery = $dbh->prepare("SELECT count(voorwerpnummer) FROM Voorwerp");
    $CountQuery->execute();
    $Count = $CountQuery->fetch()[0];
    return $Count;
}

function GetVoorwerpEigenschappen($id)
{
    global $dbh;
    $voorwerpQuery = $dbh->prepare("SELECT v.Titel, v.Beschrijving, v.Startprijs, v.Betalingswijze, g.Gebruikersnaam, v.Plaatsnaam, v.Land, v.Eindmoment, v.Verzendinstructies, v.Betalingsinstructie, v.VerkopersID FROM Voorwerp v INNER JOIN Gebruiker g ON v.VerkopersID = g.GebruikersID WHERE Voorwerpnummer = ?");
    $voorwerpQuery->execute([$id]);
    return $voorwerpQuery->fetchAll();
}

function GetVoorwerpFoto($id)
{
    global $dbh;
    $fotoQuery = $dbh->prepare("SELECT FileNaam FROM Bestand WHERE Voorwerpnummer= ?");
    $fotoQuery->execute([$id]);
    $fotoPath = $fotoQuery->fetchAll();
    return $fotoPath;
}

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


function GetNotificaties($GebruikersID, $SoortGebruiker, $BenodigdeGegevens)
{
    KijkVoorVerlopenVoorwerpen($GebruikersID, $SoortGebruiker);
    $notificaties = [];
    array_push($notificaties, GetSoortNotificaties($GebruikersID, 'voorwerpOverboden'));
    array_push($notificaties, GetSoortNotificaties($GebruikersID, 'voorwerpGekocht'));
    if ($SoortGebruiker == 'Verkoper') {
        array_push($notificaties, GetSoortNotificaties($GebruikersID, 'voorwerpVerkocht'));
        array_push($notificaties, GetSoortNotificaties($GebruikersID, 'bodGeplaatst'));
    }

    if ($BenodigdeGegevens == "telling") {
        $telling = 0;
        foreach ($notificaties as $type) {
            $telling += count($type);
        }
        return $telling;
    } elseif ($BenodigdeGegevens == "gegevens") {
        return $notificaties;
    }
}


    function KijkVoorVerlopenVoorwerpen($GebruikersID, $SoortGebruiker){
    global $dbh;
    $notificatieSoort = "voorwerpGekocht";
    if($SoortGebruiker == "verkoper"){
        $notificatieSoort = "voorwerpVerkocht";
        $queryVoorwerpen = $dbh->prepare("SELECT Voorwerpnummer FROM Voorwerp WHERE VeilingGesloten = 1 AND VerkopersID = :GebruikersID");
        $queryNotificaties = $dbh->prepare("SELECT Voorwerpnummer FROM GebruikerNotificaties WHERE GebruikersID = :GebruikersID AND NotificatieSoort = 'voorwerpVerkocht'");
    } elseif($SoortGebruiker == "koper"){
        $notificatieSoort = "voorwerpGekocht";
        $queryVoorwerpen = $dbh->prepare("SELECT Voorwerpnummer FROM Voorwerp WHERE VeilingGesloten = 0 AND KopersID = :GebruikersID");
        $queryNotificaties = $dbh->prepare("SELECT Voorwerpnummer FROM GebruikerNotificaties WHERE GebruikersID = :GebruikersID AND NotificatieSoort = 'voorwerpGekocht'");
    }
    $queryVoorwerpen->execute([
        ':GebruikersID' => $GebruikersID
    ]);
    $voorwerpen = $queryVoorwerpen->fetchAll();
    $queryNotificaties->execute([
        ':GebruikersID' => $GebruikersID
    ]);
    $notificaties = $queryNotificaties->fetchAll();

    foreach($voorwerpen as $rij){
if(in_array($rij, $notificaties) == false){
    VoegNotificatieToe($GebruikersID, $rij["Voorwerpnummer"], $notificatieSoort);
}
    }
    }

function GetSoortNotificaties($GebruikersID, $NotificatieSoort){
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM GebruikerNotificaties WHERE GebruikersID = :GebruikersID AND NotificatieSoort = :NotificatieSoort AND NotificatieGelezen = 0");
    $query->execute([
        ':GebruikersID' => $GebruikersID,
        ':NotificatieSoort' => $NotificatieSoort
    ]);
    $waardes = $query->fetchAll();
    return $waardes;
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


function UpdateVoorwerpKopersID($GebruikersID, $Voorwerpnummer)
{
    global $dbh;
    $query = $dbh->prepare("UPDATE Voorwerp SET KopersID = :GebruikersID WHERE Voorwerpnummer = :Voorwerpnummer");
    $query->execute([
        ':GebruikersID' => $GebruikersID,
        ':Voorwerpnummer' => $Voorwerpnummer
    ]);
}
    ?>
