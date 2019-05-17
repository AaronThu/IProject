--Trigger voor Verkoper not null
CREATE TRIGGER CHECK_OF_BANK_OF_CREDITCARD_NULL_IS
ON dbo.Verkoper
FOR INSERT, UPDATE AS

IF EXISTS(
  SELECT *
  FROM dbo.Verkoper AS t
  WHERE t.Rekeningnummer IS NULL AND t.Creditcard IS NULL
)
BEGIN
  RAISERROR ('Er moet minstens een creditcardnummer of een bankrekeningnummer worden opgegeven', 16, 1);
  ROLLBACK TRANSACTION;
END;
GO

--Trigger voor meer dan vier afbeeldingen
 CREATE TRIGGER CHECK_OF_VOORWERP_MAX_4_AFBEELDINGEN_HEEFT
 ON dbo.Bestand
 FOR INSERT, UPDATE AS

 IF EXISTS(
   SELECT FileNaam, VoorwerpNummer
   FROM dbo.Bestand
   GROUP BY VoorwerpNummer, FileNaam
   HAVING COUNT(VoorwerpNummer) > 4
 )
 BEGIN
   RAISERROR ('Er zijn teveel afbeeldingen geselecteerd, maximaal vier afbeeldingen toegestaan', 16, 1);
   ROLLBACK TRANSACTION;
 END;

 insert into bestand values ('f:\test1', 1)
 insert into bestand values ('f:\test2', 1)
 insert into bestand values ('f:\test3', 1)
 insert into bestand values ('f:\test4', 1)
 insert into bestand values ('f:\test5', 1)


 --Kijkt of alle verkopers in tabel verkoper ook daadwerkelijk verkoper zijn
 CREATE TRIGGER CHECK_OF_VERKOPER_STATUS_VER_HEEFT
 ON dbo.Verkoper
 FOR INSERT, UPDATE AS

 IF EXISTS(
	SELECT Gebruiker.GebruikersID, Verkoper.GebruikersID 
	FROM Gebruiker, Verkoper WHERE Gebruiker.GebruikersID = Verkoper.GebruikersID
	AND SoortGebruiker = 'kop'
 )
 BEGIN
	RAISERROR ('De gebruiker is nog niet geregistreerd als verkoper', 16, 1);
	ROLLBACK TRANSACTION
END;

--insert into Gebruiker values('test', 'voornaamtest', 'Achternaamtest', 'adres1', 'adres2', 'postco', 'plaatsnaam', 'landtest', '10-05-2011', 'emailadrestest', 'wachtwoord', 2, 'antwoordtekst', 'kop')
--insert into Verkoper values(6, 'Banknaam', 'rekeningnummer', 'Post', null)

