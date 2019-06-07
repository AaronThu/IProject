<?php
function GetVoorwerpenSearchBar($zoekresultaat, $orderOn = [], $aflopen = false)
{
    global $dbh;
    $zoekWorden = explode(" ", $zoekresultaat);
    $query = "SELECT v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies, b.FileNaam FROM Voorwerp v INNER JOIN Bestand b ON v.Voorwerpnummer = b.VoorwerpNummer  WHERE v.VeilingGesloten = 0";

    foreach ($zoekWorden as $item) {
        $query .= " AND titel LIKE '%" . $item . "%'";
    }

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
    $query .= $orderBy;
    $SearchQuery = $dbh->prepare($query);
    $SearchQuery->execute();
    $Searching = $SearchQuery->fetchAll();
    return $Searching;
}
function genereerRubriekenDropdown($id, $POSTName = "", $depth = 0)
{
    $rubrieken = GetRubrieken($id);
    if (sizeof($rubrieken) <= 0) {
        return;
    }
    echo ("<select onchange=\"SelectNext(this,'rubriekDropdown',$depth,'$POSTName')\" data-depth=$depth data-Rubrieknummer=$id class=\"form-control inputforms rubriekDropdown " . (($depth > 0) ? "noShow" : "") . "\" name=\"\">");
    echo ("<option value=\"-2\">Selecteer " . (($depth > 0) ? "Subrubriek" : "Hoofdrubriek") . "</option>");
    foreach ($rubrieken as $key => $value) {
        echo ("<option value='$value[Rubrieknummer]'>$value[Rubrieknaam]</option>");
    }
    echo ("</select>");
    foreach ($rubrieken as $key => $value) {
        genereerRubriekenDropdown($value["Rubrieknummer"], $POSTName, $depth + 1);
    }
}
// returned of meegegeven gebruiker verkoper is.
function IsVerkoper($userID)
{
    global $dbh;
    $Query = $dbh->prepare("SELECT count(Gebruikersnaam) FROM Gebruiker WHERE Gebruikersnaam = ? AND (SoortGebruiker = 'verkoper' OR SoortGebruiker = 'admin')");
    $Query->execute([$userID]);
    return $Query->fetchAll()[0][0] > 0;
}

function GetSoortNotificaties($GebruikersID, $NotificatieSoort)
{
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


function VerwijderNotificaties($GebruikersID, $notificatieID = null)

{
    global $dbh;
    if ($notificatieID !== null && is_numeric($notificatieID)) {
        $query2 = $dbh->prepare("DELETE FROM GebruikerNotificaties WHERE NotificatieSoort IN('bodGeplaatst', 'voorwerpOverboden') AND GebruikersID = :GebruikersID AND NotificatieID = :NotificatieID");
        $query2->execute([':GebruikersID' => $GebruikersID, ':NotificatieID' => $notificatieID]);

        $query1 = $dbh->prepare("UPDATE GebruikerNotificaties SET NotificatieGelezen = 1 WHERE GebruikersID = :GebruikersID AND NotificatieID = :NotificatieID");
        $query1->execute([':GebruikersID' => $GebruikersID, ':NotificatieID' => $notificatieID]);
    } else {

        $query2 = $dbh->prepare("DELETE FROM GebruikerNotificaties WHERE NotificatieSoort IN('bodGeplaatst', 'voorwerpOverboden') AND GebruikersID = :GebruikersID");
        $query2->execute([':GebruikersID' => $GebruikersID]);

        $query1 = $dbh->prepare("UPDATE GebruikerNotificaties SET NotificatieGelezen = 1 WHERE GebruikersID = :GebruikersID");
        $query1->execute([':GebruikersID' => $GebruikersID]);
    }
}

function MaakNotificatiesVerlorenAan($GebruikersID)
{
    global $dbh;
    $query = $dbh->prepare("SELECT DISTINCT(Voorwerpnummer) FROM Bod WHERE GebruikersID = :GebruikersID");
    $query->execute([
        ':GebruikersID' => $GebruikersID
    ]);
    $query->fetchAll();

    foreach ($query as $Voorwerpnummer) {
        $query2 = $dbh->prepare("SELECT Voorwerpnummer FROM Voorwerp WHERE VeilingGesloten = 1 AND Voorwerpnummer = :Voorwerpnummer AND KopersID != :GebruikersID AND Voorwerpnummer NOT IN(SELECT Voorwerpnummer FROM GebruikerNotificaties WHERE NotificatieSoort = 'verloren' AND GebruikersID = :GebruikersID2)");
        $query2->execute([
            ':Voorwerpnummer' => $Voorwerpnummer,
            '::GebruikersID' => $GebruikersID,
            ':GebruikersID2' => $GebruikersID
        ]);
        $rowcount = $query2->rowcount();

        if (empty($rowcount)) {
            VoegNotificatieToe($GebruikersID, $Voorwerpnummer, 'verloren');
        }
    }
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

function GetNotificaties($GebruikersID, $SoortGebruiker, $BenodigdeGegevens)
{
    KijkVoorVerlopenVoorwerpen($GebruikersID, $SoortGebruiker);
    MaakNotificatiesVerlorenAan($GebruikersID);
    $notificaties = [];
    array_push($notificaties, GetSoortNotificaties($GebruikersID, 'voorwerpOverboden'));
    array_push($notificaties, GetSoortNotificaties($GebruikersID, 'voorwerpGekocht'));
    if ($SoortGebruiker == 'verkoper') {
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
function KijkVoorVerlopenVoorwerpen($GebruikersID, $SoortGebruiker)
{
    global $dbh;

    if ($SoortGebruiker == "verkoper" || $SoortGebruiker == "admin") {
        $notificatieSoort = "voorwerpVerkocht";
        $queryVoorwerpen = $dbh->prepare("SELECT Voorwerpnummer FROM Voorwerp WHERE VeilingGesloten = 1 AND VerkopersID = :GebruikersID");
        $queryNotificaties = $dbh->prepare("SELECT Voorwerpnummer FROM GebruikerNotificaties WHERE GebruikersID = :GebruikersID AND NotificatieSoort = 'voorwerpVerkocht'");
    } else {
        $notificatieSoort = "voorwerpGekocht";
        $queryVoorwerpen = $dbh->prepare("SELECT Voorwerpnummer FROM Voorwerp WHERE VeilingGesloten = 1 AND KopersID = :GebruikersID");
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

    foreach ($voorwerpen as $rij) {
        if (in_array($rij, $notificaties) == false) {
            VoegNotificatieToe($GebruikersID, $rij["Voorwerpnummer"], $notificatieSoort);
        }
    }
}