/*Functie voor hoogste bieder*/
CREATE FUNCTION fnGetHoogsteBieder
(
@Voorwerpnr bigint
)
RETURNS INT
BEGIN
	RETURN
	(
	  SELECT TOP 1 GebruikersID 
	  FROM Bod 
	  WHERE VoorwerpNummer = @Voorwerpnr
	  ORDER BY Bodbedrag DESC
	)
	END
	
