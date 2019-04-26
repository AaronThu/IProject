CREATE  database test
GO
use test

CREATE TABLE betalingswijzen
(
btw_wijze VARCHAR(25) NOT NULL
CONSTRAINT PK_Betalingswijzen PRIMARY KEY (btw_wijze)
)

CREATE TABLE voorwerp
(
Voorwerpnummer INT IDENTITY,
Titel VARCHAR(50) NOT NULL,
Beschrijving VARCHAR(1000) NOT NULL,
Startprijs NUMERIC(10,2) NOT NULL,
Betalingswijze VARCHAR(25) NOT NULL DEFAULT 'Ideal',

Looptijd TINYINT NOT NULL DEFAULT 7,
BeginMoment DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
Eindmoment AS DATEADD(DAY, Looptijd,	BeginMoment),
VeilingGesloten AS 
		CASE WHEN CURRENT_TIMESTAMP > DATEADD(DAY, Looptijd,	BeginMoment)
		   	 THEN 1
			 ELSE 0 END,
CONSTRAINT PK_Voorwerp PRIMARY KEY (Voorwerpnummer),
CONSTRAINT CHK_Titel CHECK(LEN(TRIM(Titel)) > 1  ),
CONSTRAINT CHK_Startprijs CHECK(Startprijs >= 1.00),
CONSTRAINT FK_Betalingswijze FOREIGN KEY(Betalingswijze) REFERENCES betalingswijzen (btw_wijze),
CONSTRAINT CHK_Looptijd CHECK(Looptijd IN(1, 3, 5, 7, 10))
)