<?php

function DeleteRubriek($userID, $rubriekID, $accept = false)
{
    if (!$accept && !IsAdmin($userID)) {
        return false;
    }
    global $dbh;
    $Query = $dbh->prepare("DELETE FROM Rubriek WHERE Rubrieknummer = ? ");
    $Query->execute([$rubriekID]);

    $error = $Query->errorInfo();
    if ($error[0] != "00000") {
        return $error;
    }

    return true;
}

function UpdateRubriek($userID, $rubriekID, $rubriekName, $rubriekParent, $volgnummer = 1, $accept = false)
{
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

function InsertRubriek($userID, $rubriekName, $rubriekParent, $volgnummer = 1, $accept = false)
{
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

function IsAdmin($userID)
{

    global $dbh;
    $Query = $dbh->prepare("SELECT count(Gebruikersnaam) FROM Gebruiker WHERE Gebruikersnaam = ? AND SoortGebruiker = 'adm'");
    $Query->execute([$userID]);
    return $Query->fetchAll()[0][0] > 0;
}
