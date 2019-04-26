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