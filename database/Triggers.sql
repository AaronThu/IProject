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
  RAISERROR ('Er moet minstens een creditcardnummer of een bankrekeningnummer', 16, 1);
  ROLLBACK TRANSACTION;
END;
GO

-- werkt niet
-- CREATE TRIGGER CHECK_OF_VOORWER_MAX_4_AFBEELDINGEN_HEEFT
-- ON dbo.Bestand
-- FOR INSERT, UPDATE AS

-- IF EXISTS(

--   SELECT FileNaam, VoorwerpNummer
--   FROM dbo.Bestand
--   GROUP BY VoorwerpNummer, FileNaam
--   HAVING COUNT(VoorwerpNummer) > 4
-- )
-- BEGIN
--   RAISERROR ('test', 16, 1);
--   ROLLBACK TRANSACTION;
-- END;

-- insert into bestand values ('f:\test1', 1)
-- insert into bestand values ('f:\test2', 1)
-- insert into bestand values ('f:\test3', 1)
-- insert into bestand values ('f:\test4', 1)
-- insert into bestand values ('f:\test5', 1)



-- select * from bestand
-- select count(*) from bestand