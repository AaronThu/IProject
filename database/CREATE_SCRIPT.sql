/*==============================================================*/
/* Database name:  iproject2                                    */
/* Script:		   DDL                                          */
/* Created on:     13-05-2019		                            */
/*==============================================================*/


USE iproject2
GO


/*==============================================================*/
/* VoorwerpFotoNaam                                             */
/*==============================================================*/
CREATE TABLE Bestand (
    FileNaam                VARCHAR(255)        NOT NULL,       
    VoorwerpNummer		    BIGINT     		    NOT NULL,       
    CONSTRAINT PK_BESTAND PRIMARY KEY (FileNaam, VoorwerpNummer)
)
GO

/*==============================================================*/
/* Bod                                                          */
/*==============================================================*/
CREATE TABLE Bod (
    VoorwerpNummer          BIGINT              NOT NULL,
    Bodbedrag               NUMERIC(11,2)       NOT NULL,
    GebruikersID            INT                 NOT NULL,
    BodTijd                 DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT PK_BOD PRIMARY KEY (VoorwerpNummer, Bodbedrag)
)
GO

/*==============================================================*/
/* Feedback                                                     */
/*==============================================================*/
CREATE TABLE FeedBack (
	FeedbackIndex			INT IDENTITY		NOT NULL,
    BeoordelersID           INT                 NOT NULL,
    VerkopersID             INT                 NOT NULL,
    FeedbackNummer          TINYINT             NOT NULL DEFAULT 3,
    FeedbackTijd            DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT PK_FEEDBACK PRIMARY KEY (FeedbackIndex),
	CONSTRAINT CK_FEEDBACKNUMMER CHECK (FeedbackNummer BETWEEN 0 AND 5)
)
GO

/*==============================================================*/
/* Gebruiker                                                    */
/*==============================================================*/
CREATE TABLE Gebruiker (
    GebruikersID            INT IDENTITY        NOT NULL,
	Gebruikersnaam          VARCHAR(50)         NOT NULL,
    Voornaam                VARCHAR(50)         NOT NULL,
    Achternaam              VARCHAR(50)         NOT NULL,
    Adres1                  VARCHAR(50)         NOT NULL,
    Adres2                  VARCHAR(50)             NULL,
    Postcode                VARCHAR(10)             NULL,
    Plaatsnaam              VARCHAR(50)         NOT NULL,
    Land                    VARCHAR(50)         NOT NULL,
    Geboortedatum           DATE                NOT NULL,
    Emailadres              VARCHAR(50)         NOT NULL,
    Wachtwoord              VARCHAR(255)        NOT NULL,
    Vraagnummer             TINYINT             NOT NULL,
    AntwoordTekst           VARCHAR(50)         NOT NULL,
    SoortGebruiker          VARCHAR(8)          NOT NULL DEFAULT 'koper',
    CONSTRAINT PK_GEBRUIKER PRIMARY KEY (GebruikersID),
    CONSTRAINT CK_SOORTGEBRUIKER CHECK (SoortGebruiker IN ('koper', 'verkoper', 'admin'))
)
GO

/*==============================================================*/
/* Gebruikernotificaties                                        */
/*==============================================================*/
CREATE TABLE GebruikerNotificaties (
	NotificatieID			INT	IDENTITY		NOT NULL,
	GebruikersID			INT					NOT NULL,
	Voorwerpnummer			BIGINT				NOT NULL,
	NotificatieSoort		VARCHAR(25)			NOT NULL,
	NotificatieGelezen		BIT					NOT NULL DEFAULT 0,
	Datum					DATE				NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT PK_GEBRUIKERNOTIFICATIES PRIMARY KEY (NotificatieID, GebruikersID),
	CONSTRAINT CH_NOTIFICATIESOORT CHECK (NotificatieSoort IN ('voorwerpOverboden', 'voorwerpVerkocht', 'voorwerpGekocht', 'bodGeplaatst'))
)
GO

/*==============================================================*/
/* Landen                                                       */
/*==============================================================*/
CREATE TABLE Landen (
	Land				  VARCHAR(50)		NOT NULL,
	CONSTRAINT PK_LANDEN PRIMARY KEY (Land)
)

/*==============================================================*/
/* Banken                                                       */
/*==============================================================*/
CREATE TABLE Banken (
	Bank				  VARCHAR(50)		NOT NULL,
	CONSTRAINT PK_BANKEN PRIMARY KEY (Bank)
)



/*==============================================================*/
/* Gebruikerstelefoon                                           */
/*==============================================================*/
CREATE TABLE Gebruikerstelefoon (
    Volgnr              TINYINT             NOT NULL,
    GebruikersID        INT                 NOT NULL,
    Telefoonnummer      VARCHAR(10)         NOT NULL,
    CONSTRAINT PK_GEBRUIKERSTELEFOON PRIMARY KEY (Volgnr, GebruikersID),
    CONSTRAINT CK_TELEFOONNUMMER CHECK (Telefoonnummer LIKE '%[0-9]%')
)
GO

/*==============================================================*/
/* Rubriek                                                      */
/*==============================================================*/
CREATE TABLE Rubriek (
    Rubrieknummer       INT IDENTITY        NOT NULL,
    Rubrieknaam         VARCHAR(50)         NOT NULL,
    Parent_rubriek      INT                     NULL,
    Volgnr              TINYINT                 NULL,
	Status				VARCHAR(8)		    NOT NULL,
    CONSTRAINT PK_RUBRIEK PRIMARY KEY (Rubrieknummer),
	CONSTRAINT CK_STATUS_RUBRIEK CHECK(Status IN('open', 'gesloten'))
)

/*==============================================================*/
/* Verkoper                                                     */
/*==============================================================*/
CREATE TABLE Verkoper (
    GebruikersID        INT                 NOT NULL,
	SoortRekening		VARCHAR(20)			NOT NULL,
    Bank                VARCHAR(50)         NOT NULL,
    Rekeningnummer      VARCHAR(20)         NOT NULL,
	BankRekeningHouder  VARCHAR(20)         NOT NULL,
	EinddatumPas        DATE                NOT NULL,
    ControleOptieNaam   VARCHAR(12)         NOT NULL,
	Status              VARCHAR(20)			NOT NULL,
    CONSTRAINT PK_VERKOPER PRIMARY KEY (GebruikersID),
    CONSTRAINT CK_CONTROLEOPTIENAAM CHECK (ControleOptieNaam IN ('Creditcard', 'Post')),
	CONSTRAINT CK_STATUS CHECK (Status IN ('geactiveerd', 'aanvraging', 'geblokkeerd')),
	CONSTRAINT CK_EINDDATUMPAS CHECK (EinddatumPas > GETDATE()),
	CONSTRAINT CK_SOORTREKENING CHECK (SoortRekening IN ('creditcard', 'pinpas'))
)

/*==============================================================*/
/* VerkopersCode                                                */
/*==============================================================*/
CREATE TABLE VerkopersCode (
	GebruikersID		INT					NOT NULL,
	VerkopersCode		CHAR(7) 			NOT NULL,
	StartdatumCode		DATE				NOT NULL DEFAULT CURRENT_TIMESTAMP,
	 CodeVerlopen AS 
            CASE WHEN CURRENT_TIMESTAMP > DATEADD (DAY, 7, StartdatumCode)
                THEN 1
                ELSE 0
                END,
	CONSTRAINT PK_VERKOPERSCODE PRIMARY KEY (GebruikersID)
)


/*==============================================================*/
/* Betalingswijzen                                              */
/*==============================================================*/
CREATE TABLE Betalingswijzen (
    BTW_Wijze           VARCHAR(25)         NOT NULL,
    CONSTRAINT PK_BETALINGSWIJZEN PRIMARY KEY (BTW_Wijze)
)
GO

/*==============================================================*/
/* Voorwerp                                                     */
/*==============================================================*/
CREATE TABLE Voorwerp (
    Voorwerpnummer      BIGINT IDENTITY     NOT NULL,
    Titel               VARCHAR(150)         NOT NULL,
    Beschrijving        nVARCHAR(MAX)       NOT NULL,
    Startprijs          NUMERIC(10,2)       NOT NULL,
    Betalingswijze      VARCHAR(25)         NOT NULL DEFAULT 'iDeal',
    Betalingsinstructie VARCHAR(200)            NULL,
    Plaatsnaam          VARCHAR(50)             NULL,
    Land                VARCHAR(70)         NOT NULL,
    Looptijd            TINYINT             NOT NULL DEFAULT 7,
    BeginMoment         DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Verzendkosten       NUMERIC(7,2)            NULL,
    Verzendinstructies  VARCHAR(200)            NULL,
    VerkopersID         INT			        NOT NULL,
    KopersID            INT			            NULL,
    Eindmoment AS DATEADD(DAY, Looptijd, BeginMoment),
    VeilingGesloten AS 
            CASE WHEN CURRENT_TIMESTAMP > DATEADD (DAY, Looptijd, BeginMoment)
                THEN 1
                ELSE 0
                END,
    Verkoopprijs       NUMERIC(11,2)            NULL,
    CONSTRAINT PK_VOORWERP PRIMARY KEY (Voorwerpnummer),
    CONSTRAINT CK_TITEL CHECK (LEN(Titel) > 1  ),
	--CONSTRAINT CK_BESCHRIJVING CHECK (LEN(TRIM(Beschrijving)) > 10),
    CONSTRAINT CK_STARTPRIJS CHECK (Startprijs >= 1.00),
    CONSTRAINT CK_LOOPTIJD CHECK (Looptijd IN (1, 3, 5, 7, 10))
)
GO


/*==============================================================*/
/* VoorwerpInRubriek                                            */
/*==============================================================*/
CREATE TABLE VoorwerpInRubriek (
    Voorwerpnummer      BIGINT              NOT NULL,
    Rubrieknummer       INT                 NOT NULL,
    CONSTRAINT PK_VOORWERPINRUBRIEK PRIMARY KEY (VoorwerpNummer, Rubrieknummer)
)

/*==============================================================*/
/* Vraag                                                        */
/*==============================================================*/
CREATE TABLE Vraag (
    Vraagnummer         TINYINT IDENTITY    NOT NULL,
    Vraag               VARCHAR(50)	        NOT NULL,
    CONSTRAINT PK_VRAAG primary key (Vraagnummer),
    CONSTRAINT AK_VRAAG unique (Vraag)

)

/*==============================================================*/
/*RubriekFotos                                                  */
/*==============================================================*/
CREATE TABLE RubriekFotos(
Rubrieknummer      INT         NOT NULL,
RubriekFoto        VARCHAR(100) NOT NULL
CONSTRAINT PK_RUBRIEKFOTOS PRIMARY KEY (Rubrieknummer)
)