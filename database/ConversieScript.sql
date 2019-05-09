CREATE DATABASE categorieen;


CREATE table Categorieen(
ID        int       null,
Name      varchar(255) null,
Parent     int        null
 )



INSERT INTO EenmaalAndermaal.dbo.Rubriek
	SELECT ID AS Rubrieknummer,
		   Name AS title ,
		   Parent AS Parent_rubriek,
		   1 AS Volgnr
FROM categorieen.dbo.Categorieen

