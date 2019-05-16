UPDATE Items
SET Verkoper = 
WHERE Verkoper = Gebruikersnaam


INSERT INTO Voorwerp
	SELECT ID AS VoorwerpNummer,
		   Titel AS Titel,
		   Beschrijving AS beschrijving,
		   Prijs AS Startprijs,
		   Locatie AS Plaatsnaam,
		   Land AS Land,
		   VerkopersID AS SELECT GebruikersId FROM Gebruiker WHERE Gebruikersnaam = Verkoper 
FROM Items
GO




INSERT INTO Bestand
	SELECT IllustratieFile AS FileNaam,
		   ItemId AS VoorwerpNummer
FROM Illustraties
GO
