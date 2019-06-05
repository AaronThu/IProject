/*Functie hoogste bod*/

CREATE FUNCTION fnGetHoogsteBod
(
  @Voorwerpnr bigint
)
RETURNS NUMERIC(11,2)
BEGIN
  RETURN
    ( 
	  select top 1 Bodbedrag 
	  from Bod 
	  Where VoorwerpNummer = @Voorwerpnr
	  ORDER BY Bodbedrag DESC
	)
END
