/*==============================================================*/
/* Database name:  iproject2                                    */
/* Script:		   DDL                                          */
/* Created on:     13-05-2019		                            */
/*==============================================================*/
create database EenmaalAndermaal
GO

use EenmaalAndermaal
GO
/*
USE iproject2
GO*/

/*==============================================================*/
/* VoorwerpFotoNaam                                             */
/*==============================================================*/
CREATE TABLE Bestand (
    FileNaam                VARCHAR(255)        NOT NULL,       
    VoorwerpNummer		    INT     		    NOT NULL,       
    CONSTRAINT PK_BESTAND PRIMARY KEY (FileNaam, VoorwerpNummer)
)
GO

/*==============================================================*/
/* Bod                                                          */
/*==============================================================*/
CREATE TABLE Bod (
    VoorwerpNummer          INT                 NOT NULL,
    Bodbedrag               NUMERIC(11,2)       NOT NULL,
    Gebruikersnaam          VARCHAR(50)         NOT NULL,
    BodTijd                 DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT PK_BOD PRIMARY KEY (VoorwerpNummer, Bodbedrag)
)
GO

/*==============================================================*/
/* Feedback                                                     */
/*==============================================================*/
CREATE TABLE FeedBack (
    VoorwerpNummer          INT                 NOT NULL,
    SoortGebruiker          CHAR(3)             NOT NULL,
    FeedbackSoort           CHAR(8)             NOT NULL DEFAULT 'neutraal',
    FeedbackTijd            DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Commentaar              VARCHAR(255)            NULL,
    CONSTRAINT PK_FEEDBACK PRIMARY KEY (VoorwerpNummer, SoortGebruiker),
    CONSTRAINT CK_FEEDBACKSOORT CHECK (FeedbackSoort IN ('positief, negatief, neutraal'))
)
GO

/*==============================================================*/
/* Gebruiker                                                    */
/*==============================================================*/
CREATE TABLE Gebruiker (
    Gebruikersnaam          VARCHAR(50)         NOT NULL,
    Voornaam                VARCHAR(50)         NOT NULL,
    Achternaam              VARCHAR(50)         NOT NULL,
    Adres1                  VARCHAR(50)         NOT NULL,
    Adres2                  VARCHAR(50)             NULL,
    Postcode                VARCHAR(10)         NOT NULL,
    Plaatsnaam              VARCHAR(50)         NOT NULL,
    Land                    VARCHAR(50)         NOT NULL,
    Geboortedatum           DATE                NOT NULL,
    Emailadres              VARCHAR(50)         NOT NULL,
    Wachtwoord              VARCHAR(255)        NOT NULL,
    Vraagnummer             TINYINT             NOT NULL,
    AntwoordTekst           VARCHAR(50)         NOT NULL,
    SoortGebruiker          CHAR(3)             NOT NULL DEFAULT 'kop',
    CONSTRAINT PK_GEBRUIKER PRIMARY KEY (Gebruikersnaam),
    CONSTRAINT CK_SOORTGEBRUIKER CHECK (SoortGebruiker IN ('kop', 'ver', 'adm')),
)
GO

/*==============================================================*/
/* GebruikersId                                                 */
/*==============================================================*/
CREATE TABLE GebruikersId (
GebruikersID                INT IDENTITY        NOT NULL,
Gebruikersnaam              VARCHAR(50)         NOT NULL,
CONSTRAINT PK_GEBRUIKERSID PRIMARY KEY (GebruikersID)
)
GO

/*==============================================================*/
/* Gebruikerstelefoon                                           */
/*==============================================================*/
CREATE TABLE Gebruikerstelefoon (
    Volgnr              TINYINT             NOT NULL,
    Gebruikersnaam      VARCHAR(50)         NOT NULL,
    Telefoonnummer      VARCHAR(10)         NOT NULL,
    CONSTRAINT PK_GEBRUIKERSTELEFOON PRIMARY KEY (Volgnr, Gebruikersnaam),
    CONSTRAINT CK_TELEFOONNUMMER CHECK (Telefoonnummer LIKE '%[0-9]%')
)
GO

/*==============================================================*/
/* Rubriek                                                      */
/*==============================================================*/
CREATE TABLE Rubriek (
    Rubrieknummer       INT                 NOT NULL,
    Rubrieknaam         VARCHAR(50)         NOT NULL,
    Parent_rubriek      INT                     NULL,
    Volgnr              TINYINT                 NULL,
    CONSTRAINT PK_RUBRIEK PRIMARY KEY (Rubrieknummer)
)

/*==============================================================*/
/* Verkoper                                                     */
/*==============================================================*/
CREATE TABLE Verkoper (
    Gebruikersnaam      VARCHAR(50)         NOT NULL,
    Bank                VARCHAR(50)             NULL,
    Rekeningnummer      VARCHAR(20)             NULL,
    ControleOptieNaam   VARCHAR(12)         NOT NULL,
    Creditcard          VARCHAR(20)             NULL,
    CONSTRAINT PK_VERKOPER PRIMARY KEY (Gebruikersnaam),
    CONSTRAINT CK_CONTROLEOPTIENAAM CHECK (ControleOptieNaam IN ('Creditcard', 'Post'))
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
    Voorwerpnummer      INT IDENTITY        NOT NULL,
    Titel               VARCHAR(50)         NOT NULL,
    Beschrijving        VARCHAR(5000)       NOT NULL,
    Startprijs          NUMERIC(10,2)       NOT NULL,
    Betalingswijze      VARCHAR(25)         NOT NULL DEFAULT 'iDeal',
    Betalingsinstructie VARCHAR(200)            NULL,
    Plaatsnaam          VARCHAR(50)         NOT NULL,
    Land                VARCHAR(50)         NOT NULL,
    Looptijd            TINYINT             NOT NULL DEFAULT 7,
    BeginMoment         DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Verzendkosten       NUMERIC(7,2)            NULL,
    Verzendinstructies  VARCHAR(200)            NULL,
    Verkoper            VARCHAR(50)         NOT NULL,
    Koper               VARCHAR(50)             NULL,
    Eindmoment AS DATEADD(DAY, Looptijd, BeginMoment),
    VeilingGesloten AS 
            CASE WHEN CURRENT_TIMESTAMP > DATEADD (DAY, Looptijd, BeginMoment)
                THEN 1
                ELSE 0
                END,
    Verkoopprijs       NUMERIC(11,2)            NULL,
    CONSTRAINT PK_VOORWERP PRIMARY KEY (Voorwerpnummer),
    CONSTRAINT CK_TITEL CHECK (LEN(TRIM(Titel)) > 1  ),
	CONSTRAINT CK_BESCHRIJVING CHECK (LEN(TRIM(Beschrijving)) > 10),
    CONSTRAINT CK_STARTPRIJS CHECK (Startprijs >= 1.00),
    CONSTRAINT CK_LOOPTIJD CHECK (Looptijd IN (1, 3, 5, 7, 10))
)
GO

/*==============================================================*/
/* VoorwerpInRubriek                                            */
/*==============================================================*/
CREATE TABLE VoorwerpInRubriek (
    Voorwerpnummer      INT                 NOT NULL,
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