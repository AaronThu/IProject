/*==============================================================*/
/* Database name:  iproject2                                    */
/* Script:		   CONVERSIE_USERS                              */
/* Created on:     13-05-2019		                            */
/*==============================================================*/


UPDATE Users
SET Location = 'Nederland'
WHERE Location LIKE '%Nederland%'


INSERT INTO Gebruiker(Gebruikersnaam, Voornaam, Achternaam, Adres1, Plaatsnaam, Emailadres, Geboortedatum, Wachtwoord, Vraagnummer, AntwoordTekst, Postcode, Land, SoortGebruiker)
	SELECT Username AS Gebruikersnaam,
		   CASE WHEN LEFT(Username,1) BETWEEN 'a' AND 'd' THEN 'Brighton'
			   WHEN LEFT(Username,1) BETWEEN 'e' AND 'h' THEN 'Aaron'
			   WHEN LEFT(Username,1) BETWEEN 'i' AND 'l' THEN 'Wouter'
			   WHEN LEFT(Username,1) BETWEEN 'm' AND 'p' THEN 'Rutger'
			   WHEN LEFT(Username,1) BETWEEN 'q' AND 't' THEN 'Tymo'
			   WHEN LEFT(Username,1) BETWEEN 'u' AND 'x' THEN 'Josse'
			   else 'Arnoud' END
				  AS Voornaam,
		   CASE WHEN LEFT(Username,1) BETWEEN 'a' AND 'd' THEN 'Jansen'
			   WHEN LEFT(Username,1) BETWEEN 'e' AND 'h' THEN 'Henk-Jan'
			   WHEN LEFT(Username,1) BETWEEN 'i' AND 'l' THEN 'Petersen'
			   WHEN LEFT(Username,1) BETWEEN 'm' AND 'p' THEN 'Henderson'
			   WHEN LEFT(Username,1) BETWEEN 'q' AND 't' THEN 'Pieters'
			   WHEN LEFT(Username,1) BETWEEN 'u' AND 'x' THEN 'Breedveld'
			   else 'van Bers' END
		   AS Achternaam,
		   'HAN' AS Adres1,
		   'HAN' AS Plaatsnaam,
		   'TestGebruiker' AS Emailadres,
		   '01-01-1999' AS Geboortedatum,
		   '123' AS Wachtwoord,
		   1 AS Vraagnummer,
		   'vraagAntwoord' AS AntwoordTekst,
		   Postalcode AS Postcode,
		   Location AS Land,
		   'verkoper' AS SoortGebruiker
FROM Users
GO


INSERT INTO Verkoper(GebruikersID, Bank, Rekeningnummer, ControleOptieNaam, Status)
	SELECT 
	GebruikersID AS GebruikersID,
	'pinpas' AS SoortRekening,
	'Rabobank' AS Bank,
	12345678 AS Rekeningnummer,
	'TestGebruiker' AS BankRekeningHouder,
	'10-06-2020' AS EinddatumPas,
	'Post' AS ControleOptieNaam,
	'geactiveerd' AS Status
FROM Gebruiker


