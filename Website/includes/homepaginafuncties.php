<?php
function genereerArtikelen($dbh, $gegevenQuery, $columntype)
{
    $artikelen = '';
    $backgroundsize = '';
    if ($columntype == "col-md-6") {
        $backgroundsize = "cover";
    } else {
        $backgroundsize = "contain";
    }
    $queryvoorwerpen = $dbh->query("$gegevenQuery");
    while ($row = $queryvoorwerpen->fetch()) {
        $titel = $row['Titel'];
        $tijd = $row['Eindmoment'];
        $StartPrijs = $row['Startprijs'];
        $Verkoopprijs = $row['Startprijs'];
        $voorwerpNummer = $row['Voorwerpnummer'];

        $queryFoto = $dbh->prepare("SELECT * FROM Bestand WHERE Voorwerpnummer = :Voorwerpnummer");
        $queryFoto->execute([
            ":Voorwerpnummer" => $voorwerpNummer,
        ]);
        $foto = $queryFoto->fetchColumn();

        $artikelen .= '<div id = "hover" class=" ' . $columntype . ' tile kaartje" prijs-hover=' . "€" .  $Verkoopprijs . ' ">
        
        <a href = "voorwerppagina.php?voorwerpID=' . $voorwerpNummer . '" class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(http://iproject2.icasites.nl/' . $foto . '); ;background-size:' . $backgroundsize . ';background-repeat: no-repeat;background-position: center;" >
        <p class="kaartje Timer d-flex align-items-start align-content-start align-self-start" data-time="' . $tijd . '" style="background-color: rgba(75,76,77,0.75);color: #ffffff;"></p>
        <p class="kaartje text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">' . substr($titel, 0, 25) . '... </p>
                     </a>
                     
            </div>';
    }

    return $artikelen;
}

// maakt een colom met catogorieen met mee gegeven querey en columtype
function genereerCatogorie($dbh, $gegevenQuery, $columntype)
{
    $catogorie = '';

    $querycatogorie = $dbh->query("$gegevenQuery");
    while ($row = $querycatogorie->fetch()) {
        $rubriekNaam = $row['Rubrieknaam'];
        $rubriekNummer = $row['Rubrieknummer'];

        $queryFoto = $dbh->prepare("SELECT * FROM RubriekFotos WHERE Rubrieknummer = :Rubrieknummer");
        $queryFoto->execute([
            ":Rubrieknummer" => $rubriekNummer,
        ]);
        $foto = $queryFoto->fetchColumn(1);

        $catogorie .= '<div class=" ' . $columntype . '" data-hover="' . $rubriekNaam . '">
        <a href = "subrubrieken_pagina.php?rubriekID=' . $rubriekNummer . '"><div class="d-flex flex-column justify-content-between align-content-start" style="height: 250px;">
               <img style="border-radius: 50%;" src="assets/img/Rubrieken/' . $foto . '" alt="' . $foto . '" height=250 width=250> 
               </div>
               </a>   
            </div>';
    }

    return $catogorie;
}
