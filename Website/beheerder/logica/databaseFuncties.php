<?php

function DeleteRubriek($userID, $rubriekID, $accept = false)
{
    if (!$accept || !IsAdmin($userID)) {
        return false;
    }

    global $dbh;
    $Query = $dbh->prepare("UPDATE Rubriek SET Status = 'gesloten' WHERE Rubrieknummer = ?");
    $Query->execute([$rubriekID]);

    foreach (GetAllRubrieken($rubriekID) as $key => $value) {
        DeleteRubriek($userID, $value["Rubrieknummer"], $accept);
    }
}

function HerOpenRubriek($userID, $rubriekID, $accept = false)
{
    if (!$accept || !IsAdmin($userID)) {
        return false;
    }

    global $dbh;
    $Query = $dbh->prepare("UPDATE Rubriek SET Status = 'open' WHERE Rubrieknummer = ?");
    $Query->execute([$rubriekID]);

    foreach (GetAllRubrieken($rubriekID) as $key => $value) {
        HerOpenRubriek($userID, $value["Rubrieknummer"], $accept);
    }
}

function UpdateRubriek($userID, $rubriekID, $rubriekName, $rubriekParent, $volgnummer = 1, $accept = false)
{
    if (!$accept || !IsAdmin($userID)) {
        return false;
    }
    global $dbh;
    $Query = $dbh->prepare("UPDATE Rubriek SET Rubrieknaam = ?, Parent_rubriek = ?, Volgnr = ? WHERE Rubrieknummer = ?");
    $Query->execute([$rubriekName, $rubriekParent, $volgnummer, $rubriekID]);

    $error = $Query->errorInfo();
    if ($error[0] != "00000") {
        return $error;
    }

    return true;
}

function InsertRubriek($userID, $rubriekName, $rubriekParent, $volgnummer = 1, $accept = false)
{
    if (!$accept || !IsAdmin($userID)) {
        return false;
    }

    global $dbh;
    $Query = $dbh->prepare("INSERT INTO Rubriek (Rubrieknaam, Parent_rubriek,Volgnr,Status) VALUES(?,?,?,'open')");
    $Query->execute([$rubriekName, $rubriekParent, $volgnummer]);

    $error = $Query->errorInfo();
    if ($error[0] != "00000") {
        return $error;
    }

    return true;
}

function IsAdmin($userID)
{

    global $dbh;
    $Query = $dbh->prepare("SELECT count(Gebruikersnaam) FROM Gebruiker WHERE Gebruikersnaam = ? AND SoortGebruiker = 'admin'");
    $Query->execute([$userID]);
    return $Query->fetchAll()[0][0] > 0;
}

function ZoekRubrieken($zoekKeys, $orderName = false, $orderVolgnummer = false, $parentRubriek = false, $orderAflopend = false, $zoekOpNaam = true, $zoekOpParent = false)
{

    global $dbh;
    $sqlQuery = "SELECT Rubrieknaam, Rubrieknummer, Parent_rubriek,(SELECT Rubrieknaam FROM Rubriek AS PR WHERE Rubrieknummer = R.Parent_rubriek) as Parent_name, Volgnr ,Status FROM Rubriek AS R WHERE ";

    /*
    Rubrieknaam LIKE :name OR (SELECT Rubrieknaam FROM Rubriek AS PR WHERE Rubrieknummer = R.Parent_rubriek) LIKE :parent
     */

    if ($zoekOpNaam && $zoekOpParent) {
        $sqlQuery .= " Rubrieknaam LIKE :name AND (SELECT Rubrieknaam FROM Rubriek AS PR WHERE Rubrieknummer = R.Parent_rubriek) LIKE :parent ";
    } else if ($zoekOpParent) {
        $sqlQuery .= " (SELECT Rubrieknaam FROM Rubriek AS PR WHERE Rubrieknummer = R.Parent_rubriek) LIKE :parent ";
    } else {
        $sqlQuery .= " Rubrieknaam LIKE :name ";
    }

    if ($orderName === false && $orderVolgnummer === false && $orderVolgnummer === false && $parentRubriek == false) {
        $sqlQuery .= " ORDER BY Rubrieknummer";
    }

    if ($orderName === true) {
        $sqlQuery .= " ORDER BY Rubrieknaam";
    }

    if ($orderVolgnummer === true) {
        if ($orderName === true) {
            $sqlQuery .= ", Volgnr";
        } else {
            $sqlQuery .= " ORDER BY Volgnr";
        }
    }

    if ($parentRubriek === true) {
        if ($orderVolgnummer === true || $orderName === true) {
            $sqlQuery .= ", Parent_rubriek";
        } else {
            $sqlQuery .= " ORDER BY Parent_rubriek";
        }
    }

    if ($orderAflopend) {
        $sqlQuery .= " DESC";
    }
    $Query = $dbh->prepare($sqlQuery);

    if ($zoekOpNaam && $zoekOpParent) {
        $Query->execute(
            array(
                ':name' => "%$zoekKeys%",
                ':parent' => "%$zoekKeys%"
            )
        );
    } else if ($zoekOpParent) {
        $Query->execute(
            array(
                ':parent' => "%$zoekKeys%"
            )
        );
    } else {
        $Query->execute(
            array(
                ':name' => "%$zoekKeys%"
            )
        );
    }

    $error = $Query->errorInfo();
    if ($error[0] != "00000") {
        return $error;
    }
    return $Query->fetchAll();
}

function GetAllRubrieken($parent)
{
    global $dbh;
    $Query = $dbh->prepare("SELECT Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Parent_Rubriek = ?");
    $Query->execute([$parent]);
    return $Query->fetchAll();
}
