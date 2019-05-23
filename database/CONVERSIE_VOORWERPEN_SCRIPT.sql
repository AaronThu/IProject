/*==============================================================*/
/* Database name:  iproject2                                    */
/* Script:		   CONVERSIE_VOORWERPEN                         */
/* Created on:     21-05-2019		                            */
/*==============================================================*/
SET IDENTITY_INSERT dbo.Voorwerp ON;  
GO  

UPDATE Items
SET Verkoper = (SELECT TOP 1 GebruikersID FROM Gebruiker WHERE Verkoper = Gebruikersnaam)

UPDATE Items
SET Locatie = 'Nederland'
WHERE Locatie LIKE '%Nederland%'

ALTER TABLE Items
ALTER COLUMN Verkoper     INT	NOT NULL
GO

ALTER TABLE Items
ALTER COLUMN Prijs        NUMERIC(10,2)   NOT NULL
GO

UPDATE Items
SET Prijs = Prijs*1.14
WHERE Valuta = 'GBP'

UPDATE Items
SET Prijs = Prijs*0.90
WHERE Valuta = 'USD'

UPDATE Items
SET Prijs = Prijs*0.62
WHERE Valuta = 'AUD'

UPDATE Items
SET Prijs = Prijs*0.67
WHERE Valuta = 'CAD'

UPDATE Items
SET Prijs = Prijs*0.013
WHERE Valuta = 'INR'

UPDATE Items
SET Prijs = 1.00
WHERE Prijs < 1.00


INSERT INTO Voorwerp(Voorwerpnummer, Titel, Beschrijving, Startprijs, Betalingsinstructie, Plaatsnaam, Land, Verzendkosten, Verzendinstructies, VerkopersID)
	SELECT ID AS VoorwerpNummer,
		   Titel AS Titel,
		   Beschrijving AS Beschrijving,
			Prijs AS Startprijs,
			CASE WHEN LEFT(Titel, 1) BETWEEN 'a' AND 'd' THEN 'Graag via Paypal overmaken'
				 WHEN LEFT(Titel, 1) BETWEEN 'e' AND 'h' THEN 'Maak maar over naar mijn rekeningnummer'
				 WHEN LEFT(Titel, 1) BETWEEN 'i' AND 'o' THEN 'Handje contantje of anders via een tikkie!'
				 ELSE 'Maakt niet uit, als het maar wordt overgemaakt' END
				 AS Betalingsinstructie,
		    CASE WHEN LEFT(Titel, 1) BETWEEN 'a' AND 'd'THEN 'Arnhem'
				 WHEN LEFT(Titel, 1) BETWEEN 'e' AND 'g' THEN 'Nijmegen'
				 WHEN LEFT(Titel, 1) BETWEEN 'l' AND 'q' THEN 'Amsterdam'
				 ELSE 'Groningen' END
				 AS Plaatsnaam,
				 CASE WHEN Locatie IS NULL THEN 'Nederland'
		   ELSE Locatie END
				 AS Land,
			CASE WHEN LEFT(Titel, 1) BETWEEN 'i' AND 'o' THEN 5.99
				 WHEN LEFT(Titel, 1) BETWEEN 'a' AND 'c' THEN 2.00
				 WHEN LEFT(Titel, 1) BETWEEN 'f' AND 'h' THEN 12.99
				 ELSE NULL END
			 AS Verzendkosten,
			CASE WHEN LEFT(Titel, 1) BETWEEN 'q' AND 'w' THEN 'Per post, wordt goed verpakt!'
				 WHEN LEFT(Titel, 1) BETWEEN 'a' AND 'f' THEN 'Via email, 3d print het maar uit'
				 WHEN LEFT(Titel, 1) BETWEEN 'i' AND 'o' THEN 'Ophalen bij de MCdonalds'
				 ELSE NULL END
				 AS Verzendinstructies,
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
