<?php

function DeleteRubriek($userID, $rubriekID, $accept = false) {
    if (!$accept && !IsAdmin($userID)) {
        return false;
    }
    global $dbh;
    $Query = $dbh->prepare("DELETE FROM Rubriek WHERE Rubrieknummer = ? ");
    // $Query->execute([$rubriekID]);

    $error = $Query->errorInfo();
    if ($error[0] != "00000") {
        return $error;
    }
    return true;
}

function UpdateRubriek($userID, $rubriekID, $rubriekName, $rubriekParent, $volgnummer = 1, $accept = false) {
    if (!$accept && !IsAdmin($userID)) {
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

function InsertRubriek($userID, $rubriekName, $rubriekParent, $volgnummer = 1, $accept = false) {
    if (!$accept && !IsAdmin($userID)) {
        return false;
    }

    global $dbh;
    $Query = $dbh->prepare("INSERT INTO Rubriek (Rubrieknummer, Rubrieknaam, Parent_rubriek,Volgnr) VALUES(?,?,?,?)");
    $Query->execute([$rubriekName, $rubriekParent, $volgnummer]);

    $error = $Query->errorInfo();
    if ($error[0] != "00000") {
        return $error;
    }

    return true;
}

function IsAdmin($userID) {

    global $dbh;
    $Query = $dbh->prepare("SELECT count(Gebruikersnaam) FROM Gebruiker WHERE Gebruikersnaam = ? AND SoortGebruiker = 'adm'");
    $Query->execute([$userID]);
    return $Query->fetchAll()[0][0] > 0;
}

function ZoekRubrieken($zoekKeys, $orderName = false, $orderVolgnummer = false, $parentRubriek = false) {

    global $dbh;
    $sqlQuery = "SELECT Rubrieknaam, Rubrieknummer, Parent_rubriek,(SELECT Rubrieknaam FROM Rubriek AS PR WHERE Rubrieknummer = R.Parent_rubriek) as Parent_name, Volgnr FROM Rubriek AS R WHERE Rubrieknummer >= 0 AND Rubrieknaam LIKE :name OR (SELECT Rubrieknaam FROM Rubriek AS PR WHERE Rubrieknummer = R.Parent_rubriek) LIKE :parent";
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

    $Query = $dbh->prepare($sqlQuery);
    $Query->execute(array(
        ':name' => "%$zoekKeys%",
        ':parent' => "%$zoekKeys%")
    );

    $error = $Query->errorInfo();
    if ($error[0] != "00000") {
        return $error;
    }
    return $Query->fetchAll();
}