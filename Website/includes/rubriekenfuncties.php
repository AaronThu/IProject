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
function GetAllSubRubrieken($id)
{
    $rubriekenID = [$id];
    foreach (GetRubrieken($id) as $key => $value) {
        $rubriekenID = array_merge($rubriekenID, GetAllSubRubrieken($value["Rubrieknummer"]));
    }
    return $rubriekenID;
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
