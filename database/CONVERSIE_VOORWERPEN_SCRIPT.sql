--Insert de voorwerpen
SET IDENTITY_INSERT dbo.Voorwerp ON;  
GO  



--IF NOT EXISTS(SELECT * FROM Voorwerp, Items WHERE Voorwerpnummer = ID)
BEGIN
INSERT INTO Voorwerp(Voorwerpnummer, Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, VerkopersID)
	SELECT ID AS VoorwerpNummer,
		   Titel AS Titel,
		   Beschrijving AS beschrijving,
		   Prijs AS Startprijs,
		   'iDeal' AS Betalingswijze,
		   Postcode AS Plaatsnaam,
		   Locatie AS Land,
		   4 AS VerkopersID
FROM Items
END

--Insert de fotolocaties van de voorwerpen
--IF NOT EXISTS(SELECT * FROM Bestand, Illustraties WHERE IllustratieFile = Filenaam AND ItemId = VoorwerpNummer)
BEGIN
INSERT INTO Bestand
	SELECT IllustratieFile AS FileNaam,
		   ItemId AS VoorwerpNummer
FROM Illustraties
END



--Insert Rubrieknummers van de voorwerpen
INSERT INTO VoorwerpInRubriek
	SELECT ID AS Voorwerpnummer,
	Categorie AS Rubrieknummer
FROM Items
GO


DELETE FROM Illustraties
DELETE FROM Items
