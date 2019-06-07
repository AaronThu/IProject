<?php
function genereerMeldingkaart($link = "", $voorwerpNummer, $soort = "", $bericht = "", $voorwerpTitle = "")
{
    $class = "";
    $title = "";
    switch ($soort) {
        case 'bodGeplaatst':
            $class = "bod-geplaatst";
            $title = "Bod geplaats";
            break;
        case 'voorwerpVerkocht':
            $class = "verkocht";
            $title = "Voorwerp verkocht";
            break;
        case 'voorwerpGekocht':
            $class = "gewonnen";
            $title = "Voorwerp gekocht";
            break;
        case 'voorwerpOverboden':
            $class = "overboden";
            $title = "Bod overboden";
            break;
        case 'verloren':
            $class = "verloren";
            $title = "Helaas";
            break;
        default:
            $class = "";
            break;
    }
    echo ("<a href=\"$link\" class=\"meldingkaart $class\">");
    echo ("<h5>$title</h5>");
    echo ("<p>$bericht</p>");
    echo ("<p>$voorwerpTitle</p>");
    echo ("</a>");
}

// returnt artiekel op meegegeven query en columtype. (voor kaartjes op de homepagina)

function genereerArtikel($titel, $tijd, $StartPrijs, $Verkoopprijs, $voorwerpNummer, $columntype)
{
    echo ('<div id = "hover" class=" ' . $columntype . ' tile kaartje" prijs-hover=' . "€" .  $Verkoopprijs . ' >');
    echo ('<a href = "voorwerppagina.php?voorwerpID=' . $voorwerpNummer . '" class="d-flex flex-column justify-content-between align-content-start"style="height: 149px;background-image: url(http://iproject2.icasites.nl/' .  GetVoorwerpFoto($voorwerpNummer)[0][0] . '); background-size: contain; background-position:center; background-repeat:no-repeat;" >');
    echo ('<p class="kaartje Timer d-flex align-items-start align-content-start align-self-start" data-time="' . $tijd . '" style="background-color: rgba(75,76,77,0.75);color: #ffffff;"></p>');
    echo ('<p class ="kaartje text-left" style ="background-color: rgba(75,76,77,0.75);color: #ffffff; " >' . substr($titel, 0, 25) .  '... </p></a></div>');
}

function GetVerkoperVoorwerpen($id)
{
    global $dbh;
    $query = "SELECT v.Voorwerpnummer, v.Titel, Beschrijving, v.Startprijs, v.Verkoopprijs, v.Eindmoment, v.Plaatsnaam, v.Verzendinstructies FROM Voorwerp v WHERE VerkopersID = ? order by Eindmoment";
    $sqlQuery = $dbh->prepare($query);
    $sqlQuery->execute([$id]);
    return $sqlQuery->fetchAll();
}
function GetVoorwerpenVoorVerkoper($VerkopersID)
{
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM Voorwerp WHERE VerkopersID = :VerkopersID");
    $query->execute([':VerkopersID' => $VerkopersID]);
    return $query->fetchAll();
}

