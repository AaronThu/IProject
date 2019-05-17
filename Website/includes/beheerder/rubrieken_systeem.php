<?php
function DeleteRubriek($rubriekID, $accept = false) {
    if (!$accept) {
        return false;
    }
    try {
        global $dbh;
        $Query = $dbh->prepare("DELETE FROM Rubriek WHERE Rubrieknummer = ? ");
        $Query->execute([$rubriekID]);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function UpdateRubriek($rubriekID, $rubriekName, $rubriekParent, $volgnummer = 1, $accept = false) {
    if (!$accept) {
        return false;
    }
    try {
        global $dbh;
        $Query = $dbh->prepare("UPDATE Rubriek SET Rubrieknaam = ?, Parent_rubriek = ?, Volgnr = ? WHERE Rubrieknummer = ?");
        $Query->execute([$rubriekName, $rubriekParent, $volgnummer, $rubriekID]);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function InsertRubriek($rubriekName, $rubriekParent, $volgnummer = 1, $accept = false) {
    if (!$accept) {
        return false;
    }
    try {
        global $dbh;
        $Query = $dbh->prepare("INSERT INTO Rubriek (Rubrieknummer, Rubrieknaam, Parent_rubriek,Volgnr) VALUES(?,?,?,?)");
        $Query->execute([$rubriekName, $rubriekParent, $volgnummer]);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

?>