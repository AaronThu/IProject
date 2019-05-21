SET IDENTITY_INSERT dbo.Voorwerp ON;  
GO  

UPDATE Items
SET Verkoper = (SELECT TOP 1 GebruikersID FROM Gebruiker WHERE Verkoper = Gebruikersnaam)


ALTER TABLE Items
ALTER COLUMN Verkoper     INT	NOT NULL
GO

ALTER TABLE Items
ALTER COLUMN Prijs        NUMERIC(10,2)   NOT NULL
GO

INSERT INTO Voorwerp(Voorwerpnummer, Titel, Beschrijving, Startprijs, Land, VerkopersID)
	SELECT ID AS VoorwerpNummer,
		   Titel AS Titel,
		   EenmaalAndermaal.dbo.StripHTML(Beschrijving) AS Beschrijving,
		   CASE WHEN Prijs < 1.00 THEN 1.00
		   ELSE Prijs 
		   END
		    AS Startprijs,
		   Locatie AS Land,
		   Verkoper AS VerkopersID
FROM Items
GO


INSERT INTO Bestand
	SELECT IllustratieFile AS FileNaam,
		   ItemId AS VoorwerpNummer
FROM Illustraties
GO

INSERT INTO VoorwerpInRubriek(Voorwerpnummer, Rubrieknummer)
	SELECT ID AS Voorwerpnummer,
		   Categorie AS Rubrieknummer
FROM Items
GO

DELETE FROM Illustraties
DELETE FROM Items

ALTER TABLE Items
ALTER COLUMN Verkoper     VARCHAR(200)	NOT NULL
GO

ALTER TABLE Items
ALTER COLUMN Prijs      VARCHAR(100)   NOT NULL
GO


select * from Voorwerp