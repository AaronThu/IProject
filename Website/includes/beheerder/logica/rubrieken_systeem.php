<?php

function DeleteRubriek($userID, $rubriekID, $accept = false) {
    if (!$accept && !IsAdmin($userID)) {
        return false;
    }
    try {
        global $dbh;
        $Query = $dbh->prepare("DELETE FROM Rubriek WHERE Rubrieknummer = ? ");
        $Query->execute([$rubriekID]);
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function UpdateRubriek($userID, $rubriekID, $rubriekName, $rubriekParent, $volgnummer = 1, $accept = false) {
    if (!$accept && !IsAdmin($userID)) {
        return false;
    }
    try {
        global $dbh;
        $Query = $dbh->prepare("UPDATE Rubriek SET Rubrieknaam = ?, Parent_rubriek = ?, Volgnr = ? WHERE Rubrieknummer = ?");
        $Query->execute([$rubriekName, $rubriekParent, $volgnummer, $rubriekID]);
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function InsertRubriek($userID, $rubriekName, $rubriekParent, $volgnummer = 1, $accept = false) {
    if (!$accept && !IsAdmin($userID)) {
        return false;
    }
    try {
        global $dbh;
        $Query = $dbh->prepare("INSERT INTO Rubriek (Rubrieknummer, Rubrieknaam, Parent_rubriek,Volgnr) VALUES(?,?,?,?)");
        $Query->execute([$rubriekName, $rubriekParent, $volgnummer]);
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function IsAdmin($userID) {
    try {
        global $dbh;
        $Query = $dbh->prepare("SELECT count(Gebruikersnaam) FROM Gebruiker WHERE Gebruikersnaam = ? AND SoortGebruiker = 'adm'");
        $Query->execute([$userID]);
        return $Query->fetchAll()[0][0] > 0;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

?>